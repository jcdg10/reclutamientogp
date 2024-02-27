<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoPerfil extends Model
{
    use HasFactory;

    protected $table = 'candidatos_perfiles';
    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'candidato_id'
    ];
}
