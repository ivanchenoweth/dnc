<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilusersSeeder extends Seeder
{    
    public function run()
    {
        DB::table('perfilusers')->insert([
            'cve_perfil_usuario' => 'U',
            'descripcion' => 'Usuario Normal',
        ]);
        DB::table('perfilusers')->insert([
            'cve_perfil_usuario' => 'A',
            'descripcion' => 'Administrador',
        ]);
    }
}