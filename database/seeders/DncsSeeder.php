<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DncsSeeder extends Seeder
{
    public function run()
    {
        DB::table('dncs')->insert([
            'fk_id_plantillas' => 1,
            'num_emp' => '1',
            'nombre_completo' => 'JOSE LUIS LOPEZ PEREZ',
            'dep_o_ent' => 'SECRETARIA DE SEGURIDAD PUBLICA',
            'unidad_admva' => 'C5i',
            'area' => 'Tecnología',
            'grado_est' => 'Universidad,Licenciatura',
            'correo' => 'jlopez@gmail.com',
            'telefono' => '6313112200',
            'funciones' => 'Monitoreo de red, soporte técnico a usuario, mantenimiento preventivo y correctivos a sitios',
            'word_int' => '',
            'word_ava' => '',
            'excel_int' => '',
            'excel_ava' => 'Funciones y herramientas avanzadas',
            'power_point' => '',
            'nuevas_tec' => 'Competencia comunicativa a través de la competencia digital',
            'acc_institucionales' => 'Ética e Integridad en el Servicio Público.
            Valores Gubernamentales.
            Responsabilidades Administrativas de las personas servidoras públicas.
            Correcto manejo de Información
            Protocolos de Atención y Servicio.',
            'acc_des_humano' => 'Solución de conflictos
            Comunicación consciente',
            'acc_administrativas' => 'Actualización de procedimientos, Mejora Continua.
            Administración efectiva del tiempo
            Modernización administrativa y diseño organizacional',
            'otro_curso' => '',
            'interes_instructor' => 'No',
            'tema' => '',
        ]); 
    }
}