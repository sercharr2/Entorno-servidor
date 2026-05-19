<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Partida (Blackjack).
 * Relación: una partida tiene muchas manos (hasMany).
 */
class Partida extends Model
{
    protected $fillable = ['user_id', 'saldo'];

    public function manos(): HasMany
    {
        return $this->hasMany(Mano::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
