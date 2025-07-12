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
        Schema::create('otros_datos', function (Blueprint $table) {
            $table->id();
            $table->text('otro_dato')->nullable();
            $table->foreignId('datos_desbloqueo_id')->constrained('datos_desbloqueo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otros_datos');
    }
};
