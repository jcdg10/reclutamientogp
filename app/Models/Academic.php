<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;
    protected $table = 'reqacademico';
    public $timestamps = false;

    protected $fillable = [
        'escolaridad_id',
        'institucion',
        'titulo_carrera',
        'anioini',
        'aniofin',
        'estudio',
        'candidato_id'
    ];
}
