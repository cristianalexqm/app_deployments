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
        Schema::create('casa_de_apuesta', function (Blueprint $table) {
            $table->id();
            $table->string('foto', 255)->nullable(); // Foto de la casa de apuesta
            $table->text('descripcion')->nullable(); // Descripción de la casa de apuesta
            $table->string('nombre', 255)->unique(); // Nombre único de la casa de apuesta
            $table->foreignId('proveedor_cuota_id')->constrained('proveedor_cuota'); // ID del proveedor de cuota
            $table->string('link_casa_apuesta', 255); // URL de la casa de apuesta
            $table->string('pais', 255); // País donde opera la casa de apuesta
            $table->enum('estado', ['activo', 'inactivo']); // Estado de la casa de apuesta
            $table->date('fecha_alta'); // Fecha de registro
            $table->date('fecha_baja')->nullable(); // Fecha de baja (si aplica)
            $table->text('verificacion')->nullable(); // Información de verificación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa_de_apuesta');
    }
};
