<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `partidas`:
 *  - user_id  → relación con el usuario que juega.
 *  - saldo    → dinero/puntos acumulados de la partida (sube y baja con cada mano).
 *
 * Una partida agrupa varias `manos` (Blackjack: ver migración siguiente).
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('saldo')->default(100); // saldo inicial
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
