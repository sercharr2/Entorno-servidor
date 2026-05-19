<?php

namespace App\Http\Controllers;

use App\Models\Puntuacion;
use Illuminate\Support\Facades\Auth;

/**
 * YATZY / PÓKER DE DADOS
 * ----------------------------------------------------------------------
 * Sesión:
 *  - yatzy_dados        → array de 5 enteros (1..6).
 *  - yatzy_guardados    → array de 5 booleanos (true = no se vuelve a tirar).
 *  - yatzy_tirada       → contador 0..3 (máximo 3 tiradas por ronda).
 *  - yatzy_categorias   → array de categorías ya puntuadas en esta partida.
 *
 * Flujo:
 *   POST /yatzy/tirar              → relanza los dados no guardados.
 *   POST /yatzy/guardar/{idx}      → marca/desmarca un dado como guardado.
 *   POST /yatzy/puntuar/{categoria}→ calcula los puntos y los suma; nueva ronda.
 */
class YatzyController extends Controller
{
    public function jugar()
    {
        $this->inicializarSiHaceFalta();

        return view('yatzy.jugar', [
            'dados'        => session('yatzy_dados'),
            'guardados'    => session('yatzy_guardados'),
            'tirada'       => session('yatzy_tirada'),
            'categorias'   => session('yatzy_categorias', []),
            'puntosTotales'=> Puntuacion::where('user_id', Auth::id() ?? 1)->sum('puntos'),
        ]);
    }

    public function tirar()
    {
        $this->inicializarSiHaceFalta();

        // Tope de 3 tiradas por ronda.
        if (session('yatzy_tirada') >= 3) {
            return redirect()->route('yatzy.jugar');
        }

        $dados     = session('yatzy_dados');
        $guardados = session('yatzy_guardados');

        // Solo relanzamos los que NO están guardados.
        foreach ($dados as $i => $d) {
            if (!$guardados[$i]) {
                $dados[$i] = random_int(1, 6);
            }
        }

        session([
            'yatzy_dados'  => $dados,
            'yatzy_tirada' => session('yatzy_tirada') + 1,
        ]);

        return redirect()->route('yatzy.jugar');
    }

    public function guardar(int $idx)
    {
        $g = session('yatzy_guardados');
        if (isset($g[$idx])) {
            $g[$idx] = !$g[$idx]; // toggle
            session(['yatzy_guardados' => $g]);
        }
        return redirect()->route('yatzy.jugar');
    }

    public function puntuar(string $categoria)
    {
        $dados = session('yatzy_dados');
        $puntos = $this->calcularPuntos($categoria, $dados);

        // Persistimos.
        Puntuacion::create([
            'user_id'   => Auth::id() ?? 1,
            'categoria' => $categoria,
            'puntos'    => $puntos,
        ]);

        // Marcamos la categoría como usada y arrancamos nueva ronda.
        $cats = session('yatzy_categorias', []);
        $cats[] = $categoria;
        session([
            'yatzy_categorias' => $cats,
            'yatzy_dados'      => array_fill(0, 5, 0),
            'yatzy_guardados'  => array_fill(0, 5, false),
            'yatzy_tirada'     => 0,
        ]);

        return redirect()->route('yatzy.jugar');
    }

    // ------------------------------------------------------------------

    private function inicializarSiHaceFalta(): void
    {
        if (!session()->has('yatzy_dados')) {
            session([
                'yatzy_dados'      => array_fill(0, 5, 0),
                'yatzy_guardados'  => array_fill(0, 5, false),
                'yatzy_tirada'     => 0,
                'yatzy_categorias' => [],
            ]);
        }
    }

    /**
     * Calcula los puntos según la categoría.
     * `array_count_values` da un mapa cara=>cuántas veces aparece, útil para grupos.
     */
    private function calcularPuntos(string $cat, array $dados): int
    {
        $sum = array_sum($dados);
        $counts = array_count_values($dados); // ej. [6=>3, 2=>2]
        $max = $counts ? max($counts) : 0;

        switch ($cat) {
            case 'trio':     return $max >= 3 ? $sum : 0;
            case 'poker':    return $max >= 4 ? $sum : 0;
            case 'yatzy':    return $max == 5 ? 50  : 0;
            case 'full':
                // Trío + pareja (exactamente 3 y 2 de caras distintas).
                $vals = array_values($counts);
                sort($vals);
                return $vals === [2, 3] ? 25 : 0;
            case 'escalera':
                // Una escalera grande: 5 valores consecutivos.
                $unicos = array_unique($dados);
                sort($unicos);
                if (count($unicos) >= 5) {
                    for ($i = 0; $i < 4; $i++) {
                        if ($unicos[$i + 1] - $unicos[$i] !== 1) return 0;
                    }
                    return 40;
                }
                return 0;
        }
        return 0;
    }
}
