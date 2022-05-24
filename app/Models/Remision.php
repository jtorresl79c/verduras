<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remision extends Model
{
    protected $table = "remision";

    protected $fillable = [
        'id',
        'lote',
        'remision',
        'chofer',
        'contenedor',
        'producto',
        'kgs',
        'cajas',
        'recibio',
        'fecha_envio',
        'fecha_recibido',
        'fecha_descarga',
    ]; 
}

