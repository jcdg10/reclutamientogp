<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioRequerido extends Model
{
    use HasFactory;

    protected $table = 'servicio_requerido';
    public $timestamps = false;

    protected $fillable = [
        'servicio',
        'estatus'
    ];
}
