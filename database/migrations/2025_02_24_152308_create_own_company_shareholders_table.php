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
        Schema::create('accionista_empresa_propia', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_acciones');
            $table->decimal('porcentaje_acciones', 8, 2)->nullable();
            $table->date('fecha_desde');
            $table->date('fecha_hasta')->nullable();
            $table->foreignId('empresa_propia_id')->constrained('empresa_propia');
            $table->foreignId('tipo_entidad_id')->constrained('tipo_entidades');
            $table->timestamps();

            // 🔥 Clave única compuesta para evitar duplicados en la misma empresa
            $table->unique(['empresa_propia_id', 'tipo_entidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accionista_empresa_propia');
    }
};
