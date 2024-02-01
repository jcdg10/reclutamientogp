<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;
    protected $table = 'vacantes';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'fechaalta',
        'fechamod',
        'estatus',
        'estatus_vacante',
        'fecha_vacante_cubierta'
    ];
}
