<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;

class AhorcadoIAController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->missing('ahorcado_ia_palabra')) {
            return view('ahorcado-ia.index');
        }

        return view('ahorcado-ia.index', $this->estado($request));
    }

    public function postLetra(Request $request)
    {
        if ($request->session()->missing('ahorcado_ia_palabra')) {
            return redirect()->route('ahorcado-ia.index');
        }

        $letra        = mb_strtoupper(trim((string) $request->input('letra', '')), 'UTF-8');
        $letrasUsadas = (array)  $request->session()->get('ahorcado_ia_letras_usadas', []);
        $palabra      = (string) $request->session()->get('ahorcado_ia_palabra');
        $intentos     = (int)    $request->session()->get('ahorcado_ia_intentos', 6);

        $ganado  = !empty($palabra) && empty(array_diff(array_unique(str_split($palabra)), $letrasUsadas));
        $perdido = $intentos <= 0;

        if (!preg_match('/^[A-Z]$/u', $letra) || in_array($letra, $letrasUsadas) || $ganado || $perdido) {
            return redirect()->route('ahorcado-ia.index');
        }

        $letrasUsadas[] = $letra;
        $request->session()->put('ahorcado_ia_letras_usadas', $letrasUsadas);

        if (strpos($palabra, $letra) === false) {
            $request->session()->put('ahorcado_ia_intentos', $intentos - 1);
        }

        return redirect()->route('ahorcado-ia.index');
    }

    public function postReiniciar(Request $request, GeminiService $gemini)
    {
        $request->session()->forget([
            'ahorcado_ia_palabra',
            'ahorcado_ia_letras_usadas',
            'ahorcado_ia_intentos',
            'ahorcado_ia_pista',
            'ahorcado_ia_tema',
        ]);

        $tema = trim($request->input('tema', ''));

        if ($tema === '') {
            return redirect()->route('ahorcado-ia.index');
        }

        try {
            $resultado = $gemini->generateWord($tema);
            $request->session()->put('ahorcado_ia_palabra',       $resultado['palabra']);
            $request->session()->put('ahorcado_ia_letras_usadas', []);
            $request->session()->put('ahorcado_ia_intentos',      6);
            $request->session()->put('ahorcado_ia_pista',         $resultado['pista']);
            $request->session()->put('ahorcado_ia_tema',          $tema);
        } catch (\RuntimeException $e) {
            return view('ahorcado-ia.index', ['error' => $e->getMessage(), 'temaError' => $tema]);
        }

        return redirect()->route('ahorcado-ia.index');
    }

    private function estado(Request $request): array
    {
        $palabra      = (string) $request->session()->get('ahorcado_ia_palabra');
        $letrasUsadas = (array)  $request->session()->get('ahorcado_ia_letras_usadas', []);
        $intentos     = (int)    $request->session()->get('ahorcado_ia_intentos', 6);
        $pista        = (string) $request->session()->get('ahorcado_ia_pista', '');
        $fallos       = 6 - $intentos;

        $ganado  = !empty($palabra)
                   && empty(array_diff(array_unique(str_split($palabra)), $letrasUsadas))
                   && $intentos > 0;
        $perdido = $intentos <= 0;

        $letrasErroneas = array_values(array_filter(
            $letrasUsadas,
            fn($l) => strpos($palabra, $l) === false
        ));

        $tema = (string) $request->session()->get('ahorcado_ia_tema', '');

        return compact('palabra', 'letrasUsadas', 'intentos', 'fallos', 'ganado', 'perdido', 'letrasErroneas', 'pista', 'tema');
    }
}
