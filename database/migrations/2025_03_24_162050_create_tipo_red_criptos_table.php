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
        Schema::create('tipo_red_criptos', function (Blueprint $table) {
            $table->id();
            $table->string('cod', 20)->unique(); // Código único
            $table->string('red', 50); // Nombre de la red
            $table->boolean('estado')->default(1); // Estado (activo/inactivo)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_red_criptos');
    }
};
