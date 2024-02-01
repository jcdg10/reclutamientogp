<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoData extends Model
{
    use HasFactory;
    protected $table = 'datospuesto';
    public $timestamps = false;

    protected $fillable = [
        'experiencia',
        'actividades',
        'conocimientos_tecnicos',
        'competencias_necesarias',
        'vacantes_id'
    ];
}
