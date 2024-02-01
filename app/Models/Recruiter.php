<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruiter extends Model
{
    use HasFactory;

    protected $table = 'reclutador';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'estatus'
    ];
}
