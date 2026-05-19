<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `palabras` (Wordle): diccionario de palabras de 5 letras.
 * En un seeder llenarías esto con palabras válidas en español/inglés.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('palabras', function (Blueprint $table) {
            $table->id();
            $table->string('texto', 10);
            $table->unsignedTinyInteger('longitud')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('palabras');
    }
};
