<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoDocumentacion extends Model
{
    use HasFactory;

    protected $table = 'candidatos_documentacion';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'candidato_id',
        'documento'
    ];
}
