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
        Schema::create('correos_datos_personales_bancarios', function (Blueprint $table) {
            $table->id();
            $table->string('correo', 255)->unique();
            $table->string('password', 255);
            $table->foreignId('datos_personales_bancarios_id')->constrained('datos_personales_bancarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_datos_personales_bancarios');
    }
};
