<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatosProgreso extends Model
{
    use HasFactory;

    protected $table = 'candidatos_proceso';
    public $timestamps = false;

    protected $fillable = [
        'candidatos_id',
        'vacantes_id',
        'entrevista',
        'pruebatecnica',
        'pruebapsicometrica',
        'referencias',
        'entrevista_tecnica',
        'estudio_socioeconomico',
        'estatus'
    ];
}
