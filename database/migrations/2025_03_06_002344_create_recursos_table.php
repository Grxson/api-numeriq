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

        Schema::create('recursos', function (Blueprint $table) {
            $table->id('idRecurso');
            $table->enum('tipoRecurso', ['Video', 'Ejercicio', 'Recurso Adicional', 'Examen Diagnóstico', 'Examen Final']);
            $table->string('tituloRecurso');
            $table->text('descripcionRecurso')->nullable();
            $table->string('enlaceRecurso')->nullable();
            $table->integer('duracionVideo')->nullable();
            $table->string('tipoExamen')->nullable();
            $table->unsignedBigInteger('idTema');
            $table->timestamps();

            // Clave foránea para la relación con temas
            $table->foreign('idTema')->references('idTema')->on('temas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};
