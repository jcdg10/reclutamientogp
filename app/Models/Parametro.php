<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    use HasFactory;

    protected $table = 'parametros';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'nombre_sistema',
        'valor',
    ];
}
