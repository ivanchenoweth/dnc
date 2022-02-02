<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

use App\Models\Plantillas;
use App\Models\User;


class PlantillasImport implements ToModel, WithHeadingRow, WithChunkReading
{
 
    public function model(array $row)
    {
        //dd("model");
        return new Plantillas([
            'num_emp'           => $row['num_emp'],
            'nombre_completo'   => $row['nombre_completo'],
            'sexo'              => $row['sexo'],
            'nivel'             => $row['nivel'],
            'dependencia'       => $row['dependencia'],
            'unidad_admva'      => $row['unidad_admva'],
            'puesto'            => $row['puesto'],
            'municipio'         => $row['municipio'],
            'plaza'             => $row['plaza'],
            'tipo_plaza'        => $row['tipo_plaza'],
            'fuente'            => $row['fuente'],
            'plantilla'         => $row['plantilla'],
            'tipo_org'          => $row['tipo_org'],
            'num_plaza'         => $row['num_plaza'],
            //'activo'            => $row['activo'],
        ]);
    } 
    public function chunkSize(): int
    {
        return 5000;
    }
}