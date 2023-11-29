<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $primaryKey = 'segmento_id';

    protected $fillable = [
        'ponto_inicial',
        'ponto_final',
        'distancia',
        'direcao',
        'status'
    ];

}
