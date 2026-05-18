<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome');
    }

    public function index()
    {
        return $this->__invoke();
    }
}