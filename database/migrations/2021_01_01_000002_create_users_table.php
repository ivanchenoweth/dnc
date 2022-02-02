<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('fk_cve_perfil_usuario',1)->default("U");
            $table->string('name',80);
            $table->string('email',80)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',80);
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamps();  
            $table->softDeletes(); 
            $table->foreign('fk_cve_perfil_usuario')->references('cve_perfil_usuario')->
            on('perfilusers')->onDelete('cascade');
            });
    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
}