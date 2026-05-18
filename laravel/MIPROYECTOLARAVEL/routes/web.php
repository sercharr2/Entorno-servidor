<?php

use App\Http\Controllers\calculadoraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Ruta raíz → redirige al catálogo
Route::get('/', [HomeController::class, 'getHome']);

// Rutas del catálogo protegidas por login
Route::middleware(['auth'])->group(function () {

    // Catálogo
    Route::get('/catalog', [CatalogController::class, 'getIndex'])->name('catalog.index'); 
    Route::get('/catalog/create',   [CatalogController::class, 'getCreate'])->name('catalog.create');
    Route::post('/catalog/create',  [CatalogController::class, 'postCreate'])->name('catalog.postCreate');
    Route::get('/catalog/edit/{id}',[CatalogController::class, 'getEdit'])->name('catalog.edit');
    Route::put('/catalog/edit/{id}', [CatalogController::class, 'putEdit'])->name('catalog.putEdit');
    Route::get('/catalog/show/{id}',     [CatalogController::class, 'getShow'])->name('catalog.show');

    // Perfil
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //session
    Route::get('/session',   [SessionController::class, 'getSesion'])->name('session.sesion');

    //calculadora
    Route::get('/calculadora',   [calculadoraController::class, 'getCalculadora'])->name('calculadora.calculadora');
    Route::post('/calculadora/operacion',   [calculadoraController::class, 'postOperacion'])->name('calculadora.operacion');


});

require __DIR__.'/auth.php';

