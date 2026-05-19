<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Mano (cada jugada de Blackjack).
 */
class Mano extends Model
{
    protected $fillable = [
        'partida_id',
        'cartas_json',
        'cartas_crupier_json',
        'total',
        'total_crupier',
        'apuesta',
        'pago',
        'resultado',
    ];

    protected $casts = [
        'cartas_json'         => 'array',
        'cartas_crupier_json' => 'array',
    ];

    public function partida(): BelongsTo
    {
        return $this->belongsTo(Partida::class);
    }
}
