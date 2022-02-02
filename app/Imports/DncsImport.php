<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\Dncs;

class DncsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Dncs([            
            'fk_id_plantillas'  => $row['cve_plantilla'],
            'fk_cve_periodo'    => $row['cve_periodo'],
            'num_emp'           => $row['num_emp'],
            'nombre_completo'   => $row['nombre_completo'],
            'dep_o_ent'         => $row['dep_o_ent'],
            'unidad_admva'      => $row['unidad_admva'],
            'area'              => $row['area'],
            'grado_est'         => $row['grado_est'],
            'correo'            => $row['correo'],
            'telefono'          => $row['telefono'],
            'funciones'         => $row['funciones'],
            'word_int'          => $row['word_int'],
            'word_ava'          => $row['word_ava'],
            'excel_int'         => $row['excel_int'],
            'excel_ava'         => $row['excel_ava'],
            'power_point'       => $row['power_point'],
            'nuevas_tec'            => $row['nuevas_tec'],
            'acc_institucionales'   => $row['acc_institucionales'],
            'acc_des_humano'        => $row['acc_des_humano'],
            'acc_administrativas'   => $row['acc_administrativas'],
            'otro_curso'            => $row['otro_curso'],
            'interes_instructor'    => $row['interes_instructor'],
            'tema'                  => $row['tema'],  
            'activo'                => $row['activo'],
        ]);
    }
}