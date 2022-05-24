<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class folio extends Model
{
    protected $table = "folio";

    protected $fillable = [
        'id',
        'folio',
    ]; 
}
