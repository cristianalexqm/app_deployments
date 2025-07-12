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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_pila', 100);
            $table->string('apellido_paterno', 100);
            $table->string('apellido_materno', 100);
            $table->string('ruc', 11);
            $table->date('fecha_nacimiento');
            $table->string('correo', 255);
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('codigo_postal', 20)->nullable();
            $table->foreignId('entidad_id')->constrained('entidades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
