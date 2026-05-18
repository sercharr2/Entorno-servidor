<?php

namespace App\Controller;

use App\View\Renderer;

class HomeController
{
    protected $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index()
    {
        echo $this->renderer->render('home');
    }
}