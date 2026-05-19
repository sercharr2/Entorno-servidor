<?php

namespace App\Http\Controllers;

use App\Models\Palabra;
use Illuminate\Http\Request;

/**
 * WORDLE
 * ----------------------------------------------------------------------
 * Sesión:
 *  - wordle_secreto  → palabra a adivinar (5 letras, mayúsculas).
 *  - wordle_intentos → array de intentos. Cada intento es un array de 5
 *                      elementos { letra, estado: verde|amarillo|gris }.
 *
 * Ruta POST /wordle/probar:
 *  - compara letra a letra,
 *  - devuelve verde / amarillo / gris,
 *  - máximo 6 intentos.
 */
class WordleController extends Controller
{
    private const MAX_INTENTOS = 6;
    private const LONGITUD     = 5;

    public function jugar()
    {
        if (!session()->has('wordle_secreto')) {
            // Cogemos una palabra aleatoria de la BD. Si la tabla está vacía, usamos un fallback.
            $palabra = Palabra::where('longitud', self::LONGITUD)->inRandomOrder()->first();
            $secreto = strtoupper($palabra->texto ?? 'PERRO');

            session([
                'wordle_secreto'  => $secreto,
                'wordle_intentos' => [],
            ]);
        }

        $intentos = session('wordle_intentos');
        $ganado   = collect($intentos)->contains(fn ($i) => collect($i)->every(fn ($l) => $l['estado'] === 'verde'));
        $perdido  = !$ganado && count($intentos) >= self::MAX_INTENTOS;

        return view('wordle.jugar', [
            'intentos' => $intentos,
            'ganado'   => $ganado,
            'perdido'  => $perdido,
            'secreto'  => ($ganado || $perdido) ? session('wordle_secreto') : null,
            'max'      => self::MAX_INTENTOS,
        ]);
    }

    public function probar(Request $request)
    {
        $request->validate(['palabra' => 'required|string|size:' . self::LONGITUD]);

        $intento = strtoupper($request->input('palabra'));
        $secreto = session('wordle_secreto');
        $intentos = session('wordle_intentos', []);

        // Si ya se ganó/perdió, no aceptamos más.
        if (count($intentos) >= self::MAX_INTENTOS) {
            return redirect()->route('wordle.jugar');
        }

        // Cálculo verde/amarillo/gris.
        // OJO al algoritmo: una letra repetida en el intento no debe pintarse
        // dos veces amarilla si la secreta solo la contiene una vez.
        $letrasSecreto = str_split($secreto);
        $letrasIntento = str_split($intento);
        $resultado     = array_fill(0, self::LONGITUD, null);

        // Paso 1: marcar verdes y "consumir" esas posiciones del secreto.
        for ($i = 0; $i < self::LONGITUD; $i++) {
            if ($letrasIntento[$i] === $letrasSecreto[$i]) {
                $resultado[$i] = ['letra' => $letrasIntento[$i], 'estado' => 'verde'];
                $letrasSecreto[$i] = null; // ya usada
            }
        }
        // Paso 2: para las que faltan, ver si la letra está en alguna posición no consumida.
        for ($i = 0; $i < self::LONGITUD; $i++) {
            if ($resultado[$i]) continue;

            $idx = array_search($letrasIntento[$i], $letrasSecreto, true);
            if ($idx !== false) {
                $resultado[$i] = ['letra' => $letrasIntento[$i], 'estado' => 'amarillo'];
                $letrasSecreto[$idx] = null;
            } else {
                $resultado[$i] = ['letra' => $letrasIntento[$i], 'estado' => 'gris'];
            }
        }

        $intentos[] = $resultado;
        session(['wordle_intentos' => $intentos]);

        return redirect()->route('wordle.jugar');
    }
}
