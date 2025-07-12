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
        Schema::create('direcciones_cripto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_red_cripto_id')->constrained('tipo_red_criptos');
            $table->string('direccion', 255);
            $table->string('imagen_direccion', 255)->nullable();
            $table->foreignId('cuenta_cripto_id')->constrained('cuentas_cripto');
            $table->timestamps();

            $table->unique(['tipo_red_cripto_id', 'cuenta_cripto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_cripto');
    }
};
