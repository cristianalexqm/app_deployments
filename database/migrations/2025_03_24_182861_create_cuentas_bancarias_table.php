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
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta', 20);
            $table->string('cci', 20);
            $table->unsignedBigInteger('tarjeta_id')->nullable(); // Permitir nulos aquí
            $table->foreign('tarjeta_id')->references('id')->on('tarjetas')->onDelete('restrict');
            $table->foreignId('cuentas_bancarias_general_id')->constrained('cuentas_bancarias_general')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_bancarias');
    }
};
