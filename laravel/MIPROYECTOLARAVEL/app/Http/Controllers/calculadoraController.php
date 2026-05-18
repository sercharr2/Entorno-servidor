<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class calculadoraController extends Controller
{

    public function getCalculadora(){

            return view('calculadora.calculadora');

        }


    public function postOperacion(){

         return view('calculadora.operacion');

    }

}
