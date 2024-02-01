<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $table = 'experiencia_candidatos';
    public $timestamps = false;

    protected $fillable = [
        'puesto',
        'empresa',
        'destalles_puesto',
        'fechaini',
        'fechafin',
        'puesto_actual',
        'candidato_id',
    ];
}
