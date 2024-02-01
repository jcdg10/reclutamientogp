<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;
    protected $table = 'datospersonal';
    public $timestamps = false;

    protected $fillable = [
        'rangoedad',
        'sexo',
        'estadocivil',
        'lugarresidencia',
        'vacantes_id'
    ];
}
