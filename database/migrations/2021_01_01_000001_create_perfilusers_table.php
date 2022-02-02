<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilusersTable extends Migration
{
    public function up()
    {
        // perfil?user = User´s Profile, Administrator or Normal User
        Schema::create('perfilusers', function (Blueprint $table) {
            $table->id();
            $table->string('cve_perfil_usuario')->unique()->default("U");
            $table->string('descripcion',40)->default("USUARIO");
            $table->boolean('activo')->default(true);
            $table->timestamps();  
            $table->softDeletes();             
            });
    }
    public function down()
    {
        Schema::dropIfExists('perfilusers');
    }
}