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
        Schema::create('celulares_datos_personales_bancarios', function (Blueprint $table) {
            $table->id();
            $table->string('celular', 15)->unique();
            $table->foreignId('operador_movil_id')->constrained('operadores_moviles');
            $table->foreignId('datos_personales_bancarios_id')->constrained('datos_personales_bancarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celulares_datos_personales_bancarios');
    }
};
