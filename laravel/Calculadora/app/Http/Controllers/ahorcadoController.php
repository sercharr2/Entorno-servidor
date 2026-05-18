<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ahorcadoController extends Controller
{
    private array $palabras = [
        'PROGRAMACION', 'ORDENADOR', 'TECLADO', 'PANTALLA',
        'SERVIDOR', 'INTERNET', 'VARIABLE', 'FUNCION',
        'BUCLE', 'CLASE', 'OBJETO', 'METODO',
        'SESION', 'FORMULARIO', 'LARAVEL', 'CONTROLADOR',
        'MODELO', 'RUTA', 'CAMINO', 'MONTANA',
        'ELEFANTE', 'JIRAFA', 'DELFIN', 'TORTUGA',
        'FUTBOL', 'BALONCESTO', 'NATACION', 'ATLETISMO',
        'GUITARRA', 'VIOLIN', 'TROMPETA', 'BATERIA',
        'CORAZON', 'CEREBRO', 'ESQUELETO', 'MUSCULO',
        'ABOGADO', 'INGENIERO', 'ARQUITECTO', 'PILOTO',
        'BIBLIOTECA', 'HOSPITAL', 'AEROPUERTO', 'MERCADO',
        'MARIPOSA', 'ESCORPION', 'MURCIELAGO', 'CANGREJO',
    ];

    public function getHaorcado(Request $request)
    {
        if ($request->session()->missing('ahorcado_palabra')) {
            $this->iniciarJuego($request);
        }
        return view('ahorcado.ahorcado', $this->estado($request));
    }

    public function postLetra(Request $request)
    {
        if ($request->session()->missing('ahorcado_palabra')) {
            return redirect()->route('ahorcado.ahorcado');
        }

        $letra        = mb_strtoupper(trim((string) $request->input('letra', '')), 'UTF-8');
        $letrasUsadas = (array)  $request->session()->get('ahorcado_letras_usadas', []);
        $palabra      = (string) $request->session()->get('ahorcado_palabra');
        $intentos     = (int)    $request->session()->get('ahorcado_intentos', 7);

        $ganado  = empty(array_diff(array_unique(str_split($palabra)), $letrasUsadas));
        $perdido = $intentos <= 0;

        if (!preg_match('/^[A-ZÑ]$/u', $letra) || in_array($letra, $letrasUsadas) || $ganado || $perdido) {
            return redirect()->route('ahorcado.ahorcado');
        }

        $letrasUsadas[] = $letra;
        $request->session()->put('ahorcado_letras_usadas', $letrasUsadas);

        if (strpos($palabra, $letra) === false) {
            $request->session()->put('ahorcado_intentos', $intentos - 1);
        }

        return redirect()->route('ahorcado.ahorcado');
    }

    public function postReiniciar(Request $request)
    {
        $request->session()->forget(['ahorcado_palabra', 'ahorcado_letras_usadas', 'ahorcado_intentos']);
        return redirect()->route('ahorcado.ahorcado');
    }

    private function iniciarJuego(Request $request): void
    {
        $request->session()->put('ahorcado_palabra',       $this->palabras[array_rand($this->palabras)]);
        $request->session()->put('ahorcado_letras_usadas', []);
        $request->session()->put('ahorcado_intentos',      7);
    }

    private function estado(Request $request): array
    {
        $palabra      = (string) $request->session()->get('ahorcado_palabra');
        $letrasUsadas = (array)  $request->session()->get('ahorcado_letras_usadas', []);
        $intentos     = (int)    $request->session()->get('ahorcado_intentos', 7);
        $fallos       = 7 - $intentos;

        $ganado  = empty(array_diff(array_unique(str_split($palabra)), $letrasUsadas)) && $intentos > 0;
        $perdido = $intentos <= 0;

        $letrasErroneas = array_values(array_filter(
            $letrasUsadas,
            fn($l) => strpos($palabra, $l) === false
        ));

        return compact('palabra', 'letrasUsadas', 'intentos', 'fallos', 'ganado', 'perdido', 'letrasErroneas');
    }
}
