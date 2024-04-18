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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id('preguntaId');
            $table->timestamps();
            $table->text('texto');
            $table->string('clasificacion')->nullable(true);
            $table->integer('peso')->nullable(true);
            $table->foreignId('capacidadFk')->constrained('capacidades', 'capacidadId');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
