<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drivers extends Model
{
  
    protected $table = "drivers";

    protected $fillable = [
        'drivers_name',
        'email',
        'phone',
        'address',
    ]; 
}