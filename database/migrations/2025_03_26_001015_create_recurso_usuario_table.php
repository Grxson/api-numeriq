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
        Schema::create('recurso_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUsuario')->references('idUsuario')->on('usuarios')->onDelete('cascade');
            $table->foreignId('idRecurso')->references('idRecurso')->on('recursos')->onDelete('cascade');
            $table->boolean('completado')->default(false); // Campo para indicar si el recurso fue completado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurso_usuario');
    }
};
