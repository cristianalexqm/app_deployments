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
        Schema::create('empresa_propia', function (Blueprint $table) {
            $table->id();
            $table->string('representante_legal', 255)->notNull();
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos');
            $table->string('documento_gerente', 100);
            $table->string('partida_registral', 100)->nullable();
            $table->string('oficina_registral', 255)->nullable();
            $table->date('fecha_constitucion')->nullable();
            $table->enum('estado_empresa', ['activa', 'inactiva', 'suspendida']);
            $table->date('fecha_cierre')->nullable();
            $table->integer('nro_acciones_total');
            $table->string('correo_empresa', 255);
            $table->string('password', 255);
            $table->enum('tipo_control', ['tributario', 'financiero'])->nullable();
            $table->foreignId('dato_extra_tipo_entidad_id')->unique()->constrained('tipo_entidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_propia');
    }
};
