<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDNCsTable extends Migration
{   
    public function up()
    {
        Schema::create('dncs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_id_plantillas');
            $table->string('fk_cve_periodo',3)->default("211");
            $table->bigInteger('num_emp');
            //  nota los siguientes campos quedarian fuera una vez ligada a plantillas
            $table->string('nombre_completo',80);
            $table->string('dep_o_ent',180)->default("SECRETARIA DE HACIENDA");
            $table->string('unidad_admva',180)->default("SUBSECRETARIA DE RECURSOS HUMANOS");
            // terminan los campos repetitivos
            $table->string('area',180)->default("DESARROLLO ORGANIZACIONAL");            
            $table->string('grado_est',80);
            $table->string('correo',80);
            $table->string('telefono',40);
            $table->text('funciones');
            $table->text('word_int')->nullable();
            $table->text('word_ava')->nullable();
            $table->text('excel_int')->nullable();
            $table->text('excel_ava')->nullable();
            $table->text('power_point')->nullable();
            $table->text('nuevas_tec')->nullable();
            $table->text('acc_institucionales')->nullable();
            $table->text('acc_des_humano')->nullable();
            $table->text('acc_administrativas')->nullable();
            $table->text('otro_curso')->nullable();
            $table->string('interes_instructor',2)->default("No");
            $table->text('tema')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('fk_cve_periodo')->references('cve_periodo')->
            on('periodos')->onDelete('cascade');
            $table->foreign('fk_id_plantillas')->references('id')->
            on('plantillas')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('dncs');
    }
}