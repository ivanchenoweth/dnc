<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dncs extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'fk_id_plantillas',
        'fk_cve_periodo',
        'num_emp',
        'nombre_completo',
        'dep_o_ent',
        'unidad_admva',
        'area',
        'grado_est',
        'correo',
        'telefono',
        'funciones',
        'word_int',
        'word_ava',
        'excel_int',
        'excel_ava',
        'power_point',
        'nuevas_tec',
        'acc_institucionales',
        'acc_des_humano',
        'acc_administrativas',
        'otro_curso',
        'interes_instructor',
        'tema',
        'activo',
    ]; 
    
    public function plantillas() {
        return $this->hasMany(Plantillas::Class);
    }
    public function periodos() {
        return $this->hasMany(Periodos::Class);        
    }
}