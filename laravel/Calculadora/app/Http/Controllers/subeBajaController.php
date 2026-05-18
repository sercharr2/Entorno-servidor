<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subeBajaController extends Controller
{
    public function getSubeBaja(Request $request)
    {
        $numero = $request->session()->get('sube_baja_numero', 0);
        return view('sube-baja.subeBaja', compact('numero'));
    }

    public function postSubir(Request $request)
    {
        $request->session()->put('sube_baja_numero',
            $request->session()->get('sube_baja_numero', 0) + 1
        );
        return redirect()->route('sube-baja.subeBaja');
    }

    public function postBajar(Request $request)
    {
        $request->session()->put('sube_baja_numero',
            $request->session()->get('sube_baja_numero', 0) - 1
        );
        return redirect()->route('sube-baja.subeBaja');
    }

    public function postReiniciar(Request $request)
    {
        $request->session()->put('sube_baja_numero', 0);
        return redirect()->route('sube-baja.subeBaja');
    }
}
