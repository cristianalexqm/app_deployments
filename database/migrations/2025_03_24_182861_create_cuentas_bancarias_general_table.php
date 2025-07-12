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
        Schema::create('cuentas_bancarias_general', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->foreignId('clase_cuenta_id')->constrained('clases_cuentas');
            $table->boolean('tributario')->nullable();
            $table->boolean('financiero')->nullable();
            $table->foreignId('banco_acceso_id')->nullable()->constrained('banco_acceso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_bancarias_general');
    }
};
