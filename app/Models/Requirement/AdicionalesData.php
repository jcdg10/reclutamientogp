<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdicionalesData extends Model
{
    use HasFactory;
    protected $table = 'datosadicionales';
    public $timestamps = false;

    protected $fillable = [
        'desplazarse',
        'desplazarse_motivo',
        'viajar',
        'viajar_motivo',
        'disponibilidad_horario',
        'disponibilidad_horario_motivo',
        'personal_cargo',
        'num_personas_cargo',
        'persona_reporta',
        'equipo_computo',
        'vacantes_id'
    ];
}
