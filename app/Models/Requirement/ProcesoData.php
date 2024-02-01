<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoData extends Model
{
    use HasFactory;
    protected $table = 'datosproceso';
    public $timestamps = false;

    protected $fillable = [
        'duracion',
        'cantidadfiltros',
        'niveles_flitro',
        'entrevista',
        'pruebatecnica',
        'pruebapsicometrica',
        'referencias',
        'entrevista_tecnica',
        'estudio_socioeconomico',
        'vacantes_id'
    ];
}
