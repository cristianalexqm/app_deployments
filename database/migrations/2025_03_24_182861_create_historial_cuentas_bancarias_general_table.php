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
        Schema::create('historial_cuentas_bancarias_general', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['activo', 'inactivo']);
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->foreignId('cuentas_bancarias_general_id')->nullable()->constrained('cuentas_bancarias_general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_cuentas_bancarias_general');
    }
};
