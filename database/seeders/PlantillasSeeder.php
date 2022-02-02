<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Plantillas;

class PlantillasSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('plantillas')->insert([   
            'id' => "1",
            'num_emp' => '1',
            'nombre_completo' => 'JOSE LUIS LOPEZ PEREZ',
            'sexo' => 'MESCULINO',
            'nivel' => '08B',
            'dependencia' => 'CENTRO DE EVALUACION Y CONTROL DE CONFIANZA DEL EDO.',
            'unidad_admva' => 'N/D',
            'puesto' => 'INVESTIGADOR',
            'municipio' => 'N/D',
            'plaza' => 'N/D',
            'tipo_plaza' => 'N/D',
            'fuente' => 'ORGANISMOS',
            'plantilla' => 'QNA 18',
            'tipo_org' => '3C',
            'num_plaza' => 'N/D',
        ]);
        
        /*
        Aqui tarda como 25 minutos en una laptop con 12 Gb de RAM, windows 10
        demasiado lento, el comando Plantillas::truncate(); se tuvo
        que eliminar ya que esta ligada con otra tabla y no lo permitió.

        //Plantillas::truncate();
        $report = fopen(base_path("database/data/plantillas_u.csv"), "r");
        $dataRow = true;
        while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
                if (!$dataRow) {
                    Plantillas::create([
                        'num_emp' => $data['0'],
                        'nombre_completo' => $data['1'],
                        'sexo' => $data['2'],
                        'nivel' => $data['3'],
                        'dependencia' => $data['4'],
                        'unidad_admva' => $data['5'],
                        'puesto' => $data['6'],
                        'municipio' => $data['7'],
                        'plaza' => $data['8'],
                        'tipo_plaza' => $data['9'],
                        'fuente' => $data['10'],
                        'plantilla' => $data['11'],
                        'tipo_org' => $data['12'],
                        'num_plaza' => $data['13']                        
                    ]);    
                }
                $dataRow = false;
        }   
    fclose($report);
    */
    }
}