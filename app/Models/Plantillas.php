<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantillas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'num_emp',
        'nombre_completo',
        'sexo',
        'nivel',
        'dependencia',
        'unidad_admva',
        'puesto',
        'municipio',
        'plaza',
        'tipo_plaza',
        'fuente',
        'plantilla',
        'tipo_org',
        'num_plaza',
    ];
}