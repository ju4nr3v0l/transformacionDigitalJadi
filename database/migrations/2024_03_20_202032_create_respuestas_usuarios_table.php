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
        Schema::create('respuestas_usuarios', function (Blueprint $table) {
            $table->id('respuestaUsuarioId');
            $table->dateTime('fecha');
            $table->foreignId('respuestaFk')->constrained('respuestas_preguntas', 'respuestaId');
            $table->foreignId('usuarioFk')->constrained('usuarios_consultorias', 'usuarioConsultoriaId');
            $table->longText('recomendacion_copilot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas_usuarios');
    }
};
