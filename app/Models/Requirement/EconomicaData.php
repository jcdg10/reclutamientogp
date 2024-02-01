<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicaData extends Model
{
    use HasFactory;
    protected $table = 'datoseconomicos';
    public $timestamps = false;

    protected $fillable = [
        'esquemacontratacion',
        'tiposalario',
        'montominimo',
        'montomaximo',
        'jornadalaboral',
        'prestaciones_beneficios',
        'vacantes_id'
    ];
}
