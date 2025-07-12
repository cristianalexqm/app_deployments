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
        Schema::create('identificador_cuenta', function (Blueprint $table) {
            $table->id();
            $table->string('imagen_qr', 255)->nullable();
            $table->string('frase_qr', 255)->nullable();
            $table->string('celular_afiliado', 255)->nullable();
            $table->string('frase_semilla', 255)->nullable();
            $table->string('cuenta_id', 255)->nullable();
            $table->string('imagen_id', 255)->nullable();
            $table->string('correo_id', 255)->nullable();
            $table->foreignId('banco_acceso_id')->constrained('banco_acceso')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identificador_cuenta');
    }
};
