<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * ADIVINA EL NÚMERO (1-100)
 * ----------------------------------------------------------------------
 * Estado en sesión: numero_secreto (random al iniciar) + intentos.
 *
 * Flujo:
 *   GET  /adivina/jugar  → formulario.
 *   POST /adivina/probar → compara y devuelve "mayor" / "menor" / "acertaste".
 *
 * Si acierta: suma puntos al usuario (menos intentos = más puntos) y resetea.
 * Como aquí no tocamos migraciones nuevas, los puntos se guardan en
 * un campo opcional `puntos` que tu users table puede tener o no.
 */
class AdivinaController extends Controller
{
    public function jugar()
    {
        // Inicializamos la sesión solo si no había una partida en curso.
        if (!session()->has('adv_numero')) {
            session([
                'adv_numero'   => random_int(1, 100),
                'adv_intentos' => 0,
            ]);
        }

        return view('adivina.jugar', [
            'intentos' => session('adv_intentos'),
            'mensaje'  => session('adv_mensaje'),
        ]);
    }

    public function probar(Request $request)
    {
        // Validación básica: número entero entre 1 y 100.
        $request->validate(['numero' => 'required|integer|min:1|max:100']);

        $numero  = (int) $request->input('numero');
        $secreto = session('adv_numero');

        // Cada intento incrementa el contador.
        session(['adv_intentos' => session('adv_intentos') + 1]);

        if ($numero === $secreto) {
            $intentos = session('adv_intentos');

            // Fórmula simple: menos intentos = más puntos. Máximo 100, mínimo 10.
            $puntos = max(10, 100 - ($intentos - 1) * 10);

            // Si tu users tiene una columna `puntos` la incrementamos.
            $user = User::find(Auth::id() ?? 1);
            if ($user && isset($user->puntos)) {
                $user->increment('puntos', $puntos);
            }

            // Reseteamos la partida.
            session()->forget(['adv_numero', 'adv_intentos']);
            session(['adv_mensaje' => "¡Acertaste en $intentos intentos! +$puntos pts"]);
        } else {
            // Pista: el secreto es MAYOR o MENOR que lo apostado.
            session(['adv_mensaje' => $numero < $secreto ? 'El número es MAYOR' : 'El número es MENOR']);
        }

        return redirect()->route('adivina.jugar');
    }
}
