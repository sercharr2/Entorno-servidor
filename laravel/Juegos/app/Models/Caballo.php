<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caballo extends Model
{
    protected $fillable = ['carrera_id', 'numero', 'posicion'];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }
}
