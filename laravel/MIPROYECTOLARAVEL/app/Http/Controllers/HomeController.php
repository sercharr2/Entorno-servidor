<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function getHome(){

        //return redirect()->route('catalog.index');

        return redirect()->action([CatalogController::class, 'getIndex']);

    }
}
