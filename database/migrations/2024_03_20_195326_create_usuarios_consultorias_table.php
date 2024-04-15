<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios_consultorias', function (Blueprint $table) {
            $table->id('usuarioConsultoriaId');
            $table->timestamps();
            $table->string('nit');
            $table->string('nombre_inmobiliaria');
            $table->string('nombre_completo');
            $table->string('cargo');
            $table->string('celular');
            $table->string('correo');
            $table->integer('step')->default(0);
            $table->longText('objetivos_transformacion_digital');
            $table->longText('desafios_riesgos');
            $table->longText('experiencia_transformacion_digital');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_consultorias');
    }
};
