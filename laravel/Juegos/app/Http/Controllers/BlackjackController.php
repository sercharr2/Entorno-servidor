<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Mano;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * BLACKJACK / 21
 * ----------------------------------------------------------------------
 * Flujo:
 *   1. apuesta   → el jugador indica cuánto apuesta (1..saldo).
 *   2. reparto   → 2 cartas a jugador y 2 al crupier (1 oculta).
 *      Si el jugador hace 21 con 2 cartas → blackjack natural (paga 3:2).
 *   3. turno jugador → Hit / Stand / Double / Surrender.
 *   4. turno crupier → roba hasta tener ≥ 17.
 *   5. resolución → se comparan totales, se ajusta saldo y se guarda la mano.
 *
 * Estado en sesión (claves prefijadas con bj_):
 *   bj_baraja      → array de cartas restantes (cada carta = "VALOR-PALO").
 *   bj_jugador     → array de cartas del jugador.
 *   bj_crupier     → array de cartas del crupier.
 *   bj_apuesta     → entero con la apuesta de la mano.
 *   bj_doblado     → bool: si dobló no podrá pedir más cartas.
 *   bj_fase        → 'apuesta' | 'jugando' | 'terminada'.
 *   bj_resultado   → blackjack | gana | pierde | empata | rendido (al terminar).
 *   bj_pago        → variación neta del saldo (positivo gana, negativo pierde).
 */
class BlackjackController extends Controller
{
    private const SALDO_INICIAL = 100;

    /** GET /blackjack/jugar — muestra el estado actual de la mesa. */
    public function jugar()
    {
        $partida = $this->getPartida();

        // Si nunca se ha jugado, arrancamos en fase de apuesta.
        if (!session()->has('bj_fase')) {
            session(['bj_fase' => 'apuesta']);
        }

        return view('blackjack.jugar', [
            'fase'         => session('bj_fase'),
            'saldo'        => $partida->saldo,
            'jugador'      => session('bj_jugador', []),
            'crupier'      => session('bj_crupier', []),
            'totalJugador' => session('bj_jugador') ? $this->calcularTotal(session('bj_jugador')) : 0,
            'totalCrupier' => session('bj_fase') === 'terminada' && session('bj_crupier')
                                ? $this->calcularTotal(session('bj_crupier'))
                                : null,
            'apuesta'      => session('bj_apuesta'),
            'resultado'    => session('bj_resultado'),
            'pago'         => session('bj_pago'),
            'doblado'      => session('bj_doblado', false),
            // En fase 'jugando' solo enseñamos la 1ª carta del crupier.
            'mostrarCrupier' => session('bj_fase') === 'terminada',
        ]);
    }

    /** POST /blackjack/apostar — fija apuesta y reparte las cartas iniciales. */
    public function apostar(Request $request)
    {
        $partida = $this->getPartida();

        // Solo se acepta apuesta cuando la mano anterior ya está cerrada.
        if (session('bj_fase') !== 'apuesta') {
            return redirect()->route('blackjack.jugar');
        }

        $request->validate([
            'apuesta' => 'required|integer|min:1|max:' . $partida->saldo,
        ]);
        $apuesta = (int) $request->input('apuesta');

        // Repartimos.
        $baraja  = $this->crearBarajaBarajada();
        $jugador = [array_pop($baraja), array_pop($baraja)];
        $crupier = [array_pop($baraja), array_pop($baraja)];

        session([
            'bj_baraja'   => $baraja,
            'bj_jugador'  => $jugador,
            'bj_crupier'  => $crupier,
            'bj_apuesta'  => $apuesta,
            'bj_doblado'  => false,
            'bj_fase'     => 'jugando',
        ]);
        session()->forget(['bj_resultado', 'bj_pago']);

        Log::info('BJ apuesta', ['apuesta' => $apuesta, 'jugador' => $jugador, 'crupier' => $crupier]);

        // Blackjack natural del jugador (21 con 2 cartas) → resolvemos ya.
        if ($this->calcularTotal($jugador) === 21) {
            // Si el crupier también tiene blackjack, empate; si no, paga 3:2.
            if ($this->calcularTotal($crupier) === 21) {
                $this->terminar('empata');
            } else {
                $this->terminar('blackjack');
            }
        }

        return redirect()->route('blackjack.jugar');
    }

    /** POST /blackjack/pedir — Hit: una carta más al jugador. */
    public function pedir()
    {
        if (session('bj_fase') !== 'jugando' || session('bj_doblado')) {
            return redirect()->route('blackjack.jugar');
        }

        $baraja  = session('bj_baraja');
        $jugador = session('bj_jugador');
        $jugador[] = array_pop($baraja);

        session(['bj_baraja' => $baraja, 'bj_jugador' => $jugador]);

        $total = $this->calcularTotal($jugador);
        if ($total > 21) {
            // Pasado de 21 → pierde directo.
            $this->terminar('pierde');
        } elseif ($total === 21) {
            // 21 exacto → mejor plantarse automáticamente (no aporta arriesgarse).
            $this->turnoCrupier();
        }

        return redirect()->route('blackjack.jugar');
    }

    /** POST /blackjack/plantarse — Stand: pasa el turno al crupier. */
    public function plantarse()
    {
        if (session('bj_fase') !== 'jugando') {
            return redirect()->route('blackjack.jugar');
        }
        $this->turnoCrupier();
        return redirect()->route('blackjack.jugar');
    }

    /** POST /blackjack/doblar — Double: dobla apuesta, 1 carta, plantarse. */
    public function doblar()
    {
        $partida = $this->getPartida();

        // Reglas: solo en fase 'jugando', solo con 2 cartas iniciales, y con saldo suficiente.
        if (session('bj_fase') !== 'jugando' || count(session('bj_jugador')) !== 2) {
            return redirect()->route('blackjack.jugar');
        }
        if ($partida->saldo < session('bj_apuesta') * 2) {
            return redirect()->route('blackjack.jugar')->withErrors(['No tienes saldo para doblar']);
        }

        // Doblamos la apuesta y damos exactamente 1 carta al jugador.
        $baraja  = session('bj_baraja');
        $jugador = session('bj_jugador');
        $jugador[] = array_pop($baraja);

        session([
            'bj_baraja'  => $baraja,
            'bj_jugador' => $jugador,
            'bj_apuesta' => session('bj_apuesta') * 2,
            'bj_doblado' => true,
        ]);

        if ($this->calcularTotal($jugador) > 21) {
            $this->terminar('pierde');
        } else {
            $this->turnoCrupier();
        }

        return redirect()->route('blackjack.jugar');
    }

    /** POST /blackjack/rendirse — Surrender: termina la mano perdiendo la mitad. */
    public function rendirse()
    {
        if (session('bj_fase') !== 'jugando' || count(session('bj_jugador')) !== 2) {
            return redirect()->route('blackjack.jugar');
        }
        $this->terminar('rendido');
        return redirect()->route('blackjack.jugar');
    }

    /** POST /blackjack/nueva — vuelve a fase de apuesta. */
    public function nueva()
    {
        session()->forget([
            'bj_baraja', 'bj_jugador', 'bj_crupier', 'bj_apuesta',
            'bj_doblado', 'bj_resultado', 'bj_pago',
        ]);
        session(['bj_fase' => 'apuesta']);
        return redirect()->route('blackjack.jugar');
    }

    // ==================================================================
    // Lógica interna
    // ==================================================================

    /** Hace que el crupier robe hasta ≥17 y resuelve la mano. */
    private function turnoCrupier(): void
    {
        $baraja  = session('bj_baraja');
        $crupier = session('bj_crupier');

        while ($this->calcularTotal($crupier) < 17) {
            $crupier[] = array_pop($baraja);
        }

        session(['bj_baraja' => $baraja, 'bj_crupier' => $crupier]);

        $totalJ = $this->calcularTotal(session('bj_jugador'));
        $totalC = $this->calcularTotal($crupier);

        if ($totalC > 21 || $totalJ > $totalC) {
            $this->terminar('gana');
        } elseif ($totalJ < $totalC) {
            $this->terminar('pierde');
        } else {
            $this->terminar('empata');
        }
    }

    /**
     * Cierra la mano: calcula pago, actualiza saldo, guarda registro en BD
     * y deja el estado en fase 'terminada'.
     *
     * Pagos:
     *   blackjack →  +apuesta * 1.5
     *   gana      →  +apuesta
     *   empata    →  0
     *   pierde    →  -apuesta
     *   rendido   →  -apuesta / 2
     */
    private function terminar(string $resultado): void
    {
        $apuesta = session('bj_apuesta');
        $pago = match ($resultado) {
            'blackjack' => (int) ceil($apuesta * 1.5),
            'gana'      => $apuesta,
            'empata'    => 0,
            'pierde'    => -$apuesta,
            'rendido'   => -(int) ceil($apuesta / 2),
        };

        $partida = $this->getPartida();
        $partida->saldo += $pago;
        $partida->save();

        Mano::create([
            'partida_id'          => $partida->id,
            'cartas_json'         => session('bj_jugador'),
            'cartas_crupier_json' => session('bj_crupier'),
            'total'               => $this->calcularTotal(session('bj_jugador')),
            'total_crupier'       => $this->calcularTotal(session('bj_crupier')),
            'apuesta'             => $apuesta,
            'pago'                => $pago,
            'resultado'           => $resultado,
        ]);

        Log::info('BJ mano cerrada', compact('resultado', 'apuesta', 'pago'));

        session([
            'bj_fase'      => 'terminada',
            'bj_resultado' => $resultado,
            'bj_pago'      => $pago,
        ]);
    }

    /** Devuelve la partida del usuario, creándola (con saldo inicial) si no existe. */
    private function getPartida(): Partida
    {
        $userId = Auth::id() ?? User::firstOrCreate(
            ['id' => 1],
            ['name' => 'Invitado', 'email' => 'invitado@local.test', 'password' => 'demo']
        )->id;

        return Partida::firstOrCreate(
            ['user_id' => $userId],
            ['saldo'   => self::SALDO_INICIAL]
        );
    }

    /** Crea una baraja de 52 cartas barajada. Formato: "VALOR-PALO". */
    private function crearBarajaBarajada(): array
    {
        $valores = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $palos   = ['P', 'C', 'D', 'T']; // Picas, Corazones, Diamantes, Tréboles

        $baraja = [];
        foreach ($palos as $palo) {
            foreach ($valores as $v) {
                $baraja[] = $v . '-' . $palo;
            }
        }
        shuffle($baraja);
        return $baraja;
    }

    /**
     * Calcula el total óptimo de una mano.
     * Cada As suma 11 inicialmente; si nos pasamos de 21 y hay ases, bajan a 1.
     */
    private function calcularTotal(array $cartas): int
    {
        $total = 0;
        $ases  = 0;

        foreach ($cartas as $carta) {
            [$valor] = explode('-', $carta);
            if ($valor === 'A') {
                $total += 11;
                $ases++;
            } elseif (in_array($valor, ['J', 'Q', 'K'])) {
                $total += 10;
            } else {
                $total += (int) $valor;
            }
        }

        while ($total > 21 && $ases > 0) {
            $total -= 10;
            $ases--;
        }

        return $total;
    }
}
