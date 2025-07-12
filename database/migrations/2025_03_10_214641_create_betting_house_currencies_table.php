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
        Schema::create('casa_de_apuesta_moneda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('casa_de_apuesta_id')->constrained('casa_de_apuesta'); // ID de la casa de apuesta
            $table->foreignId('moneda_id')->constrained('monedas'); // ID de la moneda
            $table->enum('estado', ['activo', 'inactivo']); // Estado de la relación
            $table->timestamps();

            $table->unique(['casa_de_apuesta_id', 'moneda_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa_de_apuesta_moneda');
    }
};
