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
        Schema::create('banco_clave_dinamica', function (Blueprint $table) {
            $table->id();
            $table->string('celular_afiliado', 50)->nullable();
            $table->string('celular_imagen', 255)->nullable();
            $table->foreignId('banco_acceso_id')->constrained('banco_acceso')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banco_clave_dinamica');
    }
};
