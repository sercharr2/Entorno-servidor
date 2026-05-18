<?php

namespace App\Http\Controllers;

use App\Services\HermetoService;
use Illuminate\Http\Request;

class HermetoController extends Controller
{
    public function index(Request $request)
    {
        $historial = $request->session()->get('hermeto_historial_display', []);
        return view('hermeto.chat', compact('historial'));
    }

    public function postMensaje(Request $request, HermetoService $hermeto)
    {
        $texto = trim($request->input('mensaje', ''));

        if ($texto === '') {
            return response()->json(['error' => 'Escribe algo primero.'], 400);
        }

        $histClasico = $request->session()->get('hermeto_hist_clasico', []);
        $histModerno = $request->session()->get('hermeto_hist_moderno', []);
        $histDisplay = $request->session()->get('hermeto_historial_display', []);

        $histClasico[] = ['role' => 'user', 'parts' => [['text' => $texto]]];
        $histModerno[] = ['role' => 'user', 'parts' => [['text' => $texto]]];

        try {
            $respuestas = $hermeto->chatDual($histClasico, $histModerno);

            $histClasico[] = ['role' => 'model', 'parts' => [['text' => $respuestas['clasico']]]];
            $histModerno[] = ['role' => 'model', 'parts' => [['text' => $respuestas['moderno']]]];
            $histDisplay[] = ['tipo' => 'user',  'texto'   => $texto];
            $histDisplay[] = ['tipo' => 'dual',  'clasico' => $respuestas['clasico'], 'moderno' => $respuestas['moderno']];

            $request->session()->put('hermeto_hist_clasico',      $histClasico);
            $request->session()->put('hermeto_hist_moderno',      $histModerno);
            $request->session()->put('hermeto_historial_display', $histDisplay);

            return response()->json($respuestas);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postLimpiar(Request $request)
    {
        $request->session()->forget([
            'hermeto_hist_clasico',
            'hermeto_hist_moderno',
            'hermeto_historial_display',
        ]);
        return redirect()->route('hermeto.index');
    }
}
