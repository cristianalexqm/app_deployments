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
        Schema::create('datos_desbloqueo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_papa', 50)->nullable();
            $table->string('nombre_mama', 50)->nullable();
            $table->string('lugar_nacimiento', 50)->nullable();
            $table->string('ficha_reniec', 255)->nullable();
            $table->date('fecha_inscripcion_dni')->nullable();
            $table->date('fecha_emision_dni')->nullable();
            $table->date('fecha_vencimiento_dni')->nullable();
            $table->foreignId('datos_personales_bancarios_id')->constrained('datos_personales_bancarios')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_desbloqueo');
    }
};
