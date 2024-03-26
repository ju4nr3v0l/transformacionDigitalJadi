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
        Schema::create('respuestas_preguntas', function (Blueprint $table) {
            $table->id('respuestaId');
            $table->timestamps();
            $table->text('texto');
            $table->string('clasificacion');
            $table->integer('peso');
            $table->foreignId('preguntaFk')->constrained('preguntas', 'preguntaId');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas_preguntas');
    }
};
