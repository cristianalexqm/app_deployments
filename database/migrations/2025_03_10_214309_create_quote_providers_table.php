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
        Schema::create('proveedor_cuota', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique(); // Nombre único del proveedor
            $table->string('descripcion', 225)->nullable(); // Descripción del proveedor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_cuota');
    }
};
