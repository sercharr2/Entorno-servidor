<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `carreras`:
 *  - user_id  → quien jugó.
 *  - ganador  → número del caballo ganador (1..N). Null mientras la carrera no termina.
 *
 * Una carrera tiene muchos `caballos` (siguiente migración).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('ganador')->nullable();
            $table->unsignedTinyInteger('apuesta')->nullable(); // caballo al que apostó
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};
