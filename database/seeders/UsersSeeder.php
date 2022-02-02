<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([            
            'fk_cve_perfil_usuario' => 'A',
            'name' => 'ADMINISTRADOR DEL SISTEMA',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);
        DB::table('users')->insert([    
            'fk_cve_perfil_usuario' => 'U',
            'name' => 'Usuario DNC 2022',
            'email' => 'uDNC2022@gmail.com',
            'password' => Hash::make('uDNC2022'),
        ]);
    }
}