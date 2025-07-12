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
        Schema::create('asociado_tipo_asociado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asociado_id')->constrained('asociado');
            $table->foreignId('tipo_asociado_id')->constrained('tipo_asociado');
            $table->string('code_tipo', 100)->nullable();
            $table->string('code_sistema', 100)->nullable();
            $table->enum('estado', ['activo', 'inactivo']);
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
        Schema::dropIfExists('asociado_tipo_asociado');
    }
};
