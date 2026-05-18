<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function setup(Request $request, GeminiService $gemini)
    {
        $tema      = $request->input('tema', 'cultura general');
        $resultado = $gemini->generateWord($tema);

        // Claves de sesión exclusivas del ahorcado-ia (no interfieren con el ahorcado clásico)
        $request->session()->put('ahorcado_ia_palabra',       strtoupper($resultado['palabra']));
        $request->session()->put('ahorcado_ia_letras_usadas', []);
        $request->session()->put('ahorcado_ia_intentos',      7);
        $request->session()->put('ahorcado_ia_pista',         $resultado['pista']);

        return response()->json([
            'pista'    => $resultado['pista'],
            'longitud' => \strlen($resultado['palabra']),
        ]);
    }
}
