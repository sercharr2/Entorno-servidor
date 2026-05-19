<?php

namespace App\Http\Controllers;

/**
 * TRES EN RAYA vs IA
 * ----------------------------------------------------------------------
 * Sesión:
 *  - tres_tablero  → array de 9 posiciones ('X', 'O' o null).
 *  - tres_estado   → 'jugando' | 'gana_jugador' | 'gana_ia' | 'empate'.
 *
 * Jugador = 'X', IA = 'O'.
 *
 * Flujo:
 *   POST /tresenraya/mover/{casilla}:
 *      1) Marca la casilla del jugador (si está libre y la partida sigue).
 *      2) Comprueba si el jugador ganó.
 *      3) Si no, llama a jugadaIA() (random simple) y vuelve a comprobar.
 */
class TresEnRayaController extends Controller
{
    public function jugar()
    {
        if (!session()->has('tres_tablero')) {
            session([
                'tres_tablero' => array_fill(0, 9, null),
                'tres_estado'  => 'jugando',
            ]);
        }

        return view('tresenraya.jugar', [
            'tablero' => session('tres_tablero'),
            'estado'  => session('tres_estado'),
        ]);
    }

    public function mover(int $casilla)
    {
        // Validación: índice 0..8 y partida en curso.
        if ($casilla < 0 || $casilla > 8 || session('tres_estado') !== 'jugando') {
            return redirect()->route('tres.jugar');
        }

        $tablero = session('tres_tablero');

        // La casilla debe estar libre.
        if ($tablero[$casilla] !== null) {
            return redirect()->route('tres.jugar');
        }

        $tablero[$casilla] = 'X';
        session(['tres_tablero' => $tablero]);

        // ¿Ganó el jugador con ese movimiento?
        if ($this->comprobarGanador($tablero, 'X')) {
            session(['tres_estado' => 'gana_jugador']);
            return redirect()->route('tres.jugar');
        }
        if ($this->tableroLleno($tablero)) {
            session(['tres_estado' => 'empate']);
            return redirect()->route('tres.jugar');
        }

        // Turno de la IA.
        $tablero = $this->jugadaIA($tablero);
        session(['tres_tablero' => $tablero]);

        if ($this->comprobarGanador($tablero, 'O')) {
            session(['tres_estado' => 'gana_ia']);
        } elseif ($this->tableroLleno($tablero)) {
            session(['tres_estado' => 'empate']);
        }

        return redirect()->route('tres.jugar');
    }

    public function reiniciar()
    {
        session()->forget(['tres_tablero', 'tres_estado']);
        return redirect()->route('tres.jugar');
    }

    // ------------------------------------------------------------------

    /** IA random simple: elige una casilla libre al azar. */
    private function jugadaIA(array $tablero): array
    {
        $libres = array_keys(array_filter($tablero, fn ($v) => $v === null));
        if (empty($libres)) return $tablero;

        $tablero[$libres[array_rand($libres)]] = 'O';
        return $tablero;
    }

    /** Comprueba si la marca dada hizo línea (filas, columnas, diagonales). */
    private function comprobarGanador(array $t, string $m): bool
    {
        $lineas = [
            [0,1,2], [3,4,5], [6,7,8],   // filas
            [0,3,6], [1,4,7], [2,5,8],   // columnas
            [0,4,8], [2,4,6],            // diagonales
        ];
        foreach ($lineas as $l) {
            if ($t[$l[0]] === $m && $t[$l[1]] === $m && $t[$l[2]] === $m) return true;
        }
        return false;
    }

    private function tableroLleno(array $t): bool
    {
        return !in_array(null, $t, true);
    }
}
