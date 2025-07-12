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
        Schema::create('asociado', function (Blueprint $table) {
            $table->id();
            $table->string('nick_apodo', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('correo_recuperacion', 255);
            $table->foreignId('dato_extra_tipo_entidad_id')->unique()->constrained('tipo_entidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asociado');
    }
};
