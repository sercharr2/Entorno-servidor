<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Caballo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CARRERA DE CABALLOS
 * ----------------------------------------------------------------------
 * Estado en sesión: array de posiciones (índice = nº de caballo - 1).
 *
 * Flujo:
 *   GET  /carrera/jugar    → vista con caballos y formulario de apuesta.
 *   POST /carrera/apostar  → guarda el caballo apostado.
 *   POST /carrera/tirar    → tira un dado por cada caballo, suma a su posición,
 *                            si alguno llega a la meta (META=20) guarda al ganador.
 */
class CarreraController extends Controller
{
    private const NUM_CABALLOS = 5;
    private const META         = 20;

    public function jugar()
    {
        if (!session()->has('carrera_pos')) {
            // Posiciones iniciales = 0 para cada caballo.
            session(['carrera_pos' => array_fill(0, self::NUM_CABALLOS, 0)]);
            session()->forget(['carrera_ganador', 'carrera_apuesta', 'carrera_mensaje']);
        }

        return view('carrera.jugar', [
            'posiciones' => session('carrera_pos'),
            'meta'       => self::META,
            'apuesta'    => session('carrera_apuesta'),
            'ganador'    => session('carrera_ganador'),
            'mensaje'    => session('carrera_mensaje'),
        ]);
    }

    public function reiniciar()
    {
        session()->forget(['carrera_pos', 'carrera_ganador', 'carrera_apuesta', 'carrera_mensaje']);
        return redirect()->route('carrera.jugar');
    }

    public function apostar(Request $request)
    {
        $request->validate([
            'caballo' => 'required|integer|min:1|max:' . self::NUM_CABALLOS,
        ]);
        session(['carrera_apuesta' => (int) $request->caballo]);
        return redirect()->route('carrera.jugar');
    }

    public function tirar()
    {
        // No se puede tirar sin haber apostado, ni si ya hay ganador.
        if (!session('carrera_apuesta') || session('carrera_ganador')) {
            return redirect()->route('carrera.jugar');
        }

        $posiciones = session('carrera_pos');

        // Cada caballo tira un dado de 6 y avanza esa cantidad.
        foreach ($posiciones as $i => $pos) {
            $posiciones[$i] = $pos + random_int(1, 6);
        }

        session(['carrera_pos' => $posiciones]);

        // ¿Alguno llegó a la meta? Si hay empate, gana el de mayor posición (el primero hallado).
        $maxPos = max($posiciones);
        if ($maxPos >= self::META) {
            $idxGanador  = array_search($maxPos, $posiciones); // 0-indexado
            $numGanador  = $idxGanador + 1;                    // 1-indexado
            $apuesta     = session('carrera_apuesta');
            $userId      = Auth::id() ?? 1;

            // Persistimos la carrera y sus caballos.
            $carrera = Carrera::create([
                'user_id' => $userId,
                'ganador' => $numGanador,
                'apuesta' => $apuesta,
            ]);
            foreach ($posiciones as $i => $pos) {
                Caballo::create([
                    'carrera_id' => $carrera->id,
                    'numero'     => $i + 1,
                    'posicion'   => $pos,
                ]);
            }

            $mensaje = $apuesta === $numGanador
                ? "¡Ganaste! El caballo $numGanador llegó primero. +50 pts"
                : "Ganó el caballo $numGanador. Tu apuesta era el $apuesta.";

            session([
                'carrera_ganador' => $numGanador,
                'carrera_mensaje' => $mensaje,
            ]);
        }

        return redirect()->route('carrera.jugar');
    }
}
