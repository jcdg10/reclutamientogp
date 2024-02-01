<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'telefono',
        'email',
        'calle',
        'num_int',
        'nun_ext',
        'codigo_postal',
        'ciudad',
        'estado_id',
        'estatus',
        'referencia'
    ];
}
