<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicIdiomsData extends Model
{
    use HasFactory;
    protected $table = 'datosacademicos_idiomas';
    public $timestamps = false;

    protected $fillable = [
        'idioma',
        'datosacademicos_id'
    ];
}
