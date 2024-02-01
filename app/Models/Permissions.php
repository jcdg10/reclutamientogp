<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    protected $table = 'permisos';
    public $timestamps = false;

    protected $fillable = [
        'rol_id',
        'modulo_id',
        'permiso',
        'permitido',
    ];
}
