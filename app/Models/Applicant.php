<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $table = 'candidatos';
    protected $primaryKey = 'idcandidato';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'edad',
        'codigo',
        'telefono',
        'correo',
        'ciudad',
        'pretensiones',
        'perfil',
        'especialidad',
        'estatus_candidatos',
        'experiencia',
        'fechaalta',
        'fechamod',
        'foto_perfil'
    ];
}
