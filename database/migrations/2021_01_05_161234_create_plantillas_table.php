<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePlantillasTable extends Migration
{    
    public function up()
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('num_emp');
            $table->string('nombre_completo',60);
            $table->string('sexo',10);
            $table->string('nivel',5);
            $table->string('dependencia',120);
            $table->string('unidad_admva',180);
            $table->string('puesto',80)->nullable();
            $table->string('municipio',180)->nullable();
            $table->string('plaza',10)->nullable();
            $table->string('tipo_plaza',60)->nullable();
            $table->string('fuente',10)->nullable();
            $table->string('plantilla',10)->nullable();
            $table->string('tipo_org',20)->nullable();
            $table->string('num_plaza',5)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('plantillas');
    }
}

