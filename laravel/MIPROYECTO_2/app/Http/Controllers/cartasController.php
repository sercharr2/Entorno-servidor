<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class cartasController extends Controller
{
    // Baraja española: valor numérico (1-13) => ruta de imagen dentro de /public
    private array $cartas = [
        1  => 'images/carta1.jpg',
        2  => 'images/carta2.jpg',
        3  => 'images/carta3.jpg',
        4  => 'images/carta4.jpg',
        5  => 'images/carta5.jpg',
        6  => 'images/carta6.jpg',
        7  => 'images/carta7.jpg',
        8  => 'images/carta8.jpg',
        9  => 'images/carta9.jpg',
        10 => 'images/carta10.jpg',
        11 => 'images/carta11.jpg',
        12 => 'images/carta12.jpg',
        13 => 'images/carta13.jpg',
    ];

    // GET /cartas — muestra el juego, inicializa sesión si es la primera vez
    public function iniciar()
    {
        // Si no hay carta en sesión, empezamos nueva partida
        if (!Session::has('carta_actual')) {
            Session::put('carta_actual', rand(1, 13));
            Session::put('racha', 0);
        }

        $valor = Session::get('carta_actual');
        $racha = Session::get('racha');

        return view('cartas.juego', [
            'imagen' => $this->cartas[$valor],
            'valor'  => $valor,
            'racha'  => $racha,
        ]);
    }

    // POST /cartas/adivinar — procesa si el jugador eligió mayor o menor
    public function adivinar(Request $request)
    {
        $apuesta     = $request->input('apuesta');   // 'mayor' o 'menor'
        $cartaActual = Session::get('carta_actual');

        // Sacamos nueva carta que sea diferente a la actual
        do {
            $nuevaCarta = rand(1, 13);
        } while ($nuevaCarta === $cartaActual);

        $racha = Session::get('racha', 0);

        // Comprobamos si el jugador acertó
        $acierto = $apuesta === 'mayor' && $nuevaCarta > $cartaActual
                || $apuesta === 'menor' && $nuevaCarta < $cartaActual;

        // Actualizamos racha: +1 si acierta, 0 si falla
        $racha = $acierto ? $racha + 1 : 0;

        // Guardamos nueva carta y racha en sesión
        Session::put('carta_actual', $nuevaCarta);
        Session::put('racha', $racha);

        // 5 aciertos seguidos = ¡ganaste!
        if ($racha >= 5) {
            return redirect()->route('cartas.ganar');
        }

        // Volvemos al juego con un mensaje flash del resultado
        return redirect()->route('cartas.juego')
            ->with('resultado', $acierto ? 'acierto' : 'fallo');
    }

    // GET /cartas/ganar — pantalla de victoria
    public function ganar()
    {
        return view('cartas.ganar');
    }

    // POST /cartas/reiniciar — borra la sesión y empieza de cero
    public function reiniciar()
    {
        Session::forget(['carta_actual', 'racha']);
        return redirect()->route('cartas.juego');
    }
}
