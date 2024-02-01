<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicData extends Model
{
    use HasFactory;
    protected $table = 'datosacademicos';
    public $timestamps = false;

    protected $fillable = [
        'escolaridad',
        'vacantes_id'
    ];
}
