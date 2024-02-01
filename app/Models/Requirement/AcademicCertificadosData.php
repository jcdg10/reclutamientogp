<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCertificadosData extends Model
{
    use HasFactory;
    protected $table = 'datosacademicos_certificados';
    public $timestamps = false;

    protected $fillable = [
        'certificado',
        'datosacademicos_id'
    ];
}
