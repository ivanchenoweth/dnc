<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Plantillas;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Plantillas::all();
    }  
    public function headings(): array
    {
        return ["id","num_emp","nombre_completo", "sexo", "nivel","dependencia",
            "unidad_admva","puesto", "municipio", "plaza", "tipo_plaza", "fuente",
            "plantilla","tipo_org","num_plaza", "activo",
            "creado","actualizado"
            ];
    }     
}