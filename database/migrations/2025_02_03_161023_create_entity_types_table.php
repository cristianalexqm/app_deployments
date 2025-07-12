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
        Schema::create('tipo_entidades', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('restrict');
            $table->foreignId('entidad_id')->constrained('entidades')->onDelete('restrict');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_entidades');
    }
};
