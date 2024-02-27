<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralData extends Model
{
    use HasFactory;
    protected $table = 'datosgenerales';
    public $timestamps = false;

    protected $fillable = [
        'puesto',
        'novacantes',
        'fechasolicitud',
        'serviciore',
        'tiemasignacion',
        'cantidadtiempo',
        'modalidad',
        'horario_inicio',
        'horario_fin',
        'ejecutivoen',
        'perfil_id',
        'vacantes_id'
    ];
}
