<?php

namespace App\Models\Requirement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalData extends Model
{
    use HasFactory;
    protected $table = 'datosfinales';
    public $timestamps = false;

    protected $fillable = [
        'razonnocontratacion',
        'fechacontratacion',
        'vacantes_id'
    ];
}
