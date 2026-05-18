<?php

use App\Http\Controllers\ahorcadoController;
use App\Http\Controllers\AhorcadoIAController;
use App\Http\Controllers\calculadoraController;
use App\Http\Controllers\subeBajaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HermetoController;
use Illuminate\Support\Facades\Route;

// Ruta raíz → redirige al catálogo
Route::get('/', HomeController::class);

    //calculadora
    Route::get('/calculadora',   [calculadoraController::class, 'getCalculadora'])->name('calculadora.calculadora');
    Route::post('/calculadora/operacion',   [calculadoraController::class, 'postOperacion'])->name('calculadora.operacion');
    //sube-baja
    Route::get('/sube-baja',                    [subeBajaController::class, 'getSubeBaja']) ->name('sube-baja.subeBaja');
    Route::post('/sube-baja/subir',             [subeBajaController::class, 'postSubir'])   ->name('sube-baja.subir');
    Route::post('/sube-baja/bajar',             [subeBajaController::class, 'postBajar'])   ->name('sube-baja.bajar');
    Route::post('/sube-baja/reiniciar',         [subeBajaController::class, 'postReiniciar'])->name('sube-baja.reiniciar');
    //ahorcado
    Route::get('/ahorcado',                    [ahorcadoController::class, 'getHaorcado'])  ->name('ahorcado.ahorcado');
    Route::post('/ahorcado/letra',             [ahorcadoController::class, 'postLetra'])    ->name('ahorcado.letra');
    Route::post('/ahorcado/reiniciar',         [ahorcadoController::class, 'postReiniciar'])->name('ahorcado.reiniciar');
    //ahorcado-ia
    Route::get('/ahorcado-ia',            [AhorcadoIAController::class, 'index'])        ->name('ahorcado-ia.index');
    Route::post('/ahorcado-ia/letra',     [AhorcadoIAController::class, 'postLetra'])    ->name('ahorcado-ia.letra');
    Route::post('/ahorcado-ia/reiniciar', [AhorcadoIAController::class, 'postReiniciar'])->name('ahorcado-ia.reiniciar');
    Route::post('/generar-palabra',       [GameController::class, 'setup']);
    //hermeto
    Route::get('/hermeto',              [HermetoController::class, 'index'])       ->name('hermeto.index');
    Route::post('/hermeto/mensaje',     [HermetoController::class, 'postMensaje']) ->name('hermeto.mensaje');
    Route::post('/hermeto/limpiar',     [HermetoController::class, 'postLimpiar']) ->name('hermeto.limpiar');
