<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cartasController;

Route::get('/', function () {
    return view('welcome');
});

// Juego Mayor o Menor
Route::get('/cartas',           [cartasController::class, 'iniciar'])->name('cartas.juego');
Route::post('/cartas/adivinar', [cartasController::class, 'adivinar'])->name('cartas.adivinar');
Route::get('/cartas/ganar',     [cartasController::class, 'ganar'])->name('cartas.ganar');
Route::post('/cartas/reiniciar',[cartasController::class, 'reiniciar'])->name('cartas.reiniciar');
