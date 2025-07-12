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
        Schema::create('casa_de_apuesta_moneda_tipo_asociado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_asociado_id')->constrained('tipo_asociado'); // ID del tipo de asociado
            $table->foreignId('casa_de_apuesta_moneda_id')->constrained('casa_de_apuesta_moneda'); // ID de la casa de apuesta moneda
            $table->enum('estado', ['activo', 'inactivo']); // Estado de la relación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa_de_apuesta_moneda_tipo_asociado');
    }
};
