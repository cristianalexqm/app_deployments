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
        Schema::create('tipo_asociado', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('nombre', 100)->unique();
            $table->enum('tipo_control', ['tributario', 'financiero']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_asociado');
    }
};
