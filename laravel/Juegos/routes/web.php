<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlackjackController;
use App\Http\Controllers\AdivinaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\YatzyController;
use App\Http\Controllers\WordleController;
use App\Http\Controllers\MastermindController;
use App\Http\Controllers\TresEnRayaController;

/*
|--------------------------------------------------------------------------
| Rutas de los 7 juegos
|--------------------------------------------------------------------------
| Cada bloque agrupa las rutas de un juego bajo un prefijo. Si el examen
| solo pide UN juego, copia su bloque a tu routes/web.php.
*/

Route::get('/', fn () => view('index'));

// 1) BLACKJACK ----------------------------------------------------------
Route::prefix('blackjack')->group(function () {
    Route::get('/jugar',      [BlackjackController::class, 'jugar'])->name('blackjack.jugar');
    Route::post('/apostar',   [BlackjackController::class, 'apostar'])->name('blackjack.apostar');
    Route::post('/pedir',     [BlackjackController::class, 'pedir'])->name('blackjack.pedir');
    Route::post('/plantarse', [BlackjackController::class, 'plantarse'])->name('blackjack.plantarse');
    Route::post('/doblar',    [BlackjackController::class, 'doblar'])->name('blackjack.doblar');
    Route::post('/rendirse',  [BlackjackController::class, 'rendirse'])->name('blackjack.rendirse');
    Route::post('/nueva',     [BlackjackController::class, 'nueva'])->name('blackjack.nueva');
});

// 2) ADIVINA EL NÚMERO --------------------------------------------------
Route::prefix('adivina')->group(function () {
    Route::get('/jugar',  [AdivinaController::class, 'jugar'])->name('adivina.jugar');
    Route::post('/probar', [AdivinaController::class, 'probar'])->name('adivina.probar');
});

// 3) CARRERA DE CABALLOS ------------------------------------------------
Route::prefix('carrera')->group(function () {
    Route::get('/jugar',    [CarreraController::class, 'jugar'])->name('carrera.jugar');
    Route::post('/apostar', [CarreraController::class, 'apostar'])->name('carrera.apostar');
    Route::post('/tirar',   [CarreraController::class, 'tirar'])->name('carrera.tirar');
    Route::post('/reiniciar', [CarreraController::class, 'reiniciar'])->name('carrera.reiniciar');
});

// 4) YATZY --------------------------------------------------------------
Route::prefix('yatzy')->group(function () {
    Route::get('/jugar',          [YatzyController::class, 'jugar'])->name('yatzy.jugar');
    Route::post('/tirar',         [YatzyController::class, 'tirar'])->name('yatzy.tirar');
    Route::post('/guardar/{idx}', [YatzyController::class, 'guardar'])->name('yatzy.guardar');
    Route::post('/puntuar/{categoria}', [YatzyController::class, 'puntuar'])->name('yatzy.puntuar');
});

// 5) WORDLE -------------------------------------------------------------
Route::prefix('wordle')->group(function () {
    Route::get('/jugar',  [WordleController::class, 'jugar'])->name('wordle.jugar');
    Route::post('/probar', [WordleController::class, 'probar'])->name('wordle.probar');
});

// 6) MASTERMIND ---------------------------------------------------------
Route::prefix('mastermind')->group(function () {
    Route::get('/jugar',  [MastermindController::class, 'jugar'])->name('mastermind.jugar');
    Route::post('/probar', [MastermindController::class, 'probar'])->name('mastermind.probar');
});

// 7) TRES EN RAYA -------------------------------------------------------
Route::prefix('tresenraya')->group(function () {
    Route::get('/jugar',           [TresEnRayaController::class, 'jugar'])->name('tres.jugar');
    Route::post('/mover/{casilla}', [TresEnRayaController::class, 'mover'])->name('tres.mover');
    Route::post('/reiniciar',      [TresEnRayaController::class, 'reiniciar'])->name('tres.reiniciar');
});
