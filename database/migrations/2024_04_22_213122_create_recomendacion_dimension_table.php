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
        Schema::create('recomendacion_dimension', function (Blueprint $table) {
            $table->id('recomendacionDimensionId');
            $table->foreignId('usuarioFk')->constrained('usuarios_consultorias', 'usuarioConsultoriaId');
            $table->foreignId('dimensionFk')->constrained('dimensiones', 'dimensionId');
            $table->dateTime('fecha');
            $table->longText('recomendacion_copilot')->nullable();
            $table->longText('promt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recomendacion_dimension');
    }
};
