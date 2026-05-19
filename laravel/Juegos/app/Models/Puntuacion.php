<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puntuacion extends Model
{
    protected $table = 'puntuaciones';
    protected $fillable = ['user_id', 'partida_id', 'categoria', 'puntos'];
}
