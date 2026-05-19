<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `caballos`:
 *  - carrera_id → a qué carrera pertenece.
 *  - numero     → identificador del caballo (1..N).
 *  - posicion   → cuánto ha avanzado (acumulado).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('caballos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('numero');
            $table->unsignedInteger('posicion')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caballos');
    }
};
