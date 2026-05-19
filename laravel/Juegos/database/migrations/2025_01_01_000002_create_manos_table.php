<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla `manos`:
 *  - partida_id           → a qué partida pertenece esta mano.
 *  - cartas_json          → cartas del jugador serializadas (ej. ["A-P","10-C"]).
 *  - cartas_crupier_json  → cartas del crupier.
 *  - total                → suma final del jugador.
 *  - total_crupier        → suma final del crupier (puede ser null si se rindió).
 *  - apuesta              → cantidad apostada en esta mano.
 *  - pago                 → variación de saldo (positivo=gana, negativo=pierde, 0=empate).
 *  - resultado            → blackjack | gana | pierde | empata | rendido.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('manos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained()->cascadeOnDelete();
            $table->json('cartas_json');
            $table->json('cartas_crupier_json')->nullable();
            $table->integer('total');
            $table->integer('total_crupier')->nullable();
            $table->integer('apuesta');
            $table->integer('pago');
            $table->string('resultado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manos');
    }
};
