<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'descripcion',
        'fecha_ini',
        'fecha_fin',
    ];
}
