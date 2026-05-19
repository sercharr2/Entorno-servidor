<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    protected $fillable = ['user_id', 'ganador', 'apuesta'];

    public function caballos(): HasMany
    {
        return $this->hasMany(Caballo::class);
    }
}
