<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `puntuaciones` (Yatzy):
 *  - user_id    → quién jugó.
 *  - partida_id → opcional, agrupa categorías de una misma partida.
 *  - categoria  → 'trio','escalera','full','poker','yatzy', etc.
 *  - puntos     → puntos obtenidos en esa categoría.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('puntuaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('partida_id')->nullable();
            $table->string('categoria');
            $table->integer('puntos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puntuaciones');
    }
};
