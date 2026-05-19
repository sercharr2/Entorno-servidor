<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * MASTERMIND
 * ----------------------------------------------------------------------
 * Sesión:
 *  - mm_secreto    → array de 4 colores (de 6 posibles).
 *  - mm_intentos   → array de { combinacion, negras, blancas }.
 *
 * Reglas:
 *  - Negra: color correcto en posición correcta.
 *  - Blanca: color correcto en posición incorrecta.
 *  - Máximo 10 intentos.
 */
class MastermindController extends Controller
{
    private const COLORES      = ['R', 'V', 'A', 'M', 'N', 'B']; // Rojo, Verde, Azul, Marrón, Negro, Blanco
    private const LONGITUD     = 4;
    private const MAX_INTENTOS = 10;

    public function jugar()
    {
        if (!session()->has('mm_secreto')) {
            // Combinación secreta aleatoria (puede haber colores repetidos).
            $secreto = [];
            for ($i = 0; $i < self::LONGITUD; $i++) {
                $secreto[] = self::COLORES[array_rand(self::COLORES)];
            }
            session([
                'mm_secreto'  => $secreto,
                'mm_intentos' => [],
            ]);
        }

        $intentos = session('mm_intentos');
        $ganado   = collect($intentos)->contains(fn ($i) => $i['negras'] === self::LONGITUD);
        $perdido  = !$ganado && count($intentos) >= self::MAX_INTENTOS;

        return view('mastermind.jugar', [
            'intentos' => $intentos,
            'colores'  => self::COLORES,
            'longitud' => self::LONGITUD,
            'ganado'   => $ganado,
            'perdido'  => $perdido,
            'secreto'  => ($ganado || $perdido) ? session('mm_secreto') : null,
            'max'      => self::MAX_INTENTOS,
        ]);
    }

    public function probar(Request $request)
    {
        // Validación: deben venir 4 colores válidos.
        $request->validate([
            'colores'   => 'required|array|size:' . self::LONGITUD,
            'colores.*' => 'required|in:' . implode(',', self::COLORES),
        ]);

        $intento = $request->input('colores');
        $secreto = session('mm_secreto');

        // Algoritmo clásico: primero negras, luego blancas sin reusar posiciones.
        $negras = 0;
        $sec    = $secreto;
        $int    = $intento;

        // Paso 1: negras (posición exacta) - marcamos como null las consumidas.
        for ($i = 0; $i < self::LONGITUD; $i++) {
            if ($int[$i] === $sec[$i]) {
                $negras++;
                $sec[$i] = $int[$i] = null;
            }
        }
        // Paso 2: blancas (color correcto, posición errónea).
        $blancas = 0;
        for ($i = 0; $i < self::LONGITUD; $i++) {
            if ($int[$i] === null) continue;
            $idx = array_search($int[$i], $sec, true);
            if ($idx !== false) {
                $blancas++;
                $sec[$idx] = null;
            }
        }

        $intentos = session('mm_intentos');
        $intentos[] = [
            'combinacion' => $intento,
            'negras'      => $negras,
            'blancas'     => $blancas,
        ];
        session(['mm_intentos' => $intentos]);

        return redirect()->route('mastermind.jugar');
    }
}
