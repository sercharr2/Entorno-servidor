<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounterController extends Controller
{
    /**
     * Muestra la vista principal con el valor actual del contador.
     */
    public function index(Request $request)
    {
        // Si no existe la clave en sesión, la inicializamos a 0
        $count = $request->session()->get('counter', 0);

        return view('counter.index', compact('count'));
    }

    /**
     * Incrementa el contador en 1.
     */
    public function increment(Request $request)
    {
        $count = $request->session()->get('counter', 0);
        $request->session()->put('counter', $count + 1);

        return redirect()->route('counter.index');
    }

    /**
     * Decrementa el contador en 1.
     */
    public function decrement(Request $request)
    {
        $count = $request->session()->get('counter', 0);
        $request->session()->put('counter', $count - 1);

        return redirect()->route('counter.index');
    }

    /**
     * Reinicia el contador a 0.
     */
    public function reset(Request $request)
    {
        $request->session()->put('counter', 0);

        return redirect()->route('counter.index');
    }
}