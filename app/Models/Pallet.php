<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    protected $table = "pallet";

    protected $fillable = [
        'id_remision',
        'peso_bruto',
        'cajas',
        'tara',
        'kg_prom',
        'peso_neto',
    ]; 
}
