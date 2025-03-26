<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id('idInscripcion');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idTema');
            $table->enum('estado', ['inscrito', 'activo', 'completado']);
            $table->date('fechaInscripcion');
            $table->decimal('progreso', 5, 2)->default(0);  // Porcentaje de avance
            $table->timestamps();

            $table->foreign('idUsuario')->references('idusuario')->on('usuarios');
            $table->foreign('idTema')->references('idTema')->on('temas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
