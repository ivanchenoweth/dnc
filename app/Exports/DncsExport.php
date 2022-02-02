<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Dncs;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DncsExport implements FromCollection, WithHeadings
{
    
    public function collection()
    {
        return Dncs::all();
    }
    
    public function headings(): array
    {
        return ["id","id_plantillas","cve_periodo","num_emp","nombre_completo",
            "dep_o_ent","unidad_admva","area", "grado_est", "correo", "telefono",
            "funciones","word_int","word_ava", "excel_int", "excel_ava", "power_point",
            "nuevas_tec","acc_institucionales","acc_des_humano", "acc_administrativas", 
            "otro_curso", "interes_instructor","tema", "activo",
            "creado","actualizado"
            ];
    } 
}
