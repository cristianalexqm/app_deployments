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
        Schema::create('banco_acceso', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->foreignId('tipo_banco_id')->constrained('tipos_bancos');
            $table->string('numero_tarjeta', 16)->nullable()->unique();
            $table->string('dni_username', 255);
            $table->string('clave_web', 15);
            $table->string('pin', 15)->nullable();
            $table->foreignId('celular_banco_acceso_id')->constrained('celulares_datos_personales_bancarios')->onDelete('restrict');
            $table->foreignId('correo_banco_acceso_id')->constrained('correos_datos_personales_bancarios')->onDelete('restrict');
            $table->foreignId('datos_personales_bancarios_id')->constrained('datos_personales_bancarios');
            $table->timestamps();

            // Restricción compuesta para que un mismo acceso no tenga duplicado un mismo tipo de banco.
            $table->unique(['datos_personales_bancarios_id', 'tipo_banco_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banco_acceso');
    }
};
