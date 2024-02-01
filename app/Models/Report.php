<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reporte';
    public $timestamps = false;

    protected $fillable = [
        'reporte',
        'ruta',
        'fechaalta',
        'fechamod',
    ];
}
