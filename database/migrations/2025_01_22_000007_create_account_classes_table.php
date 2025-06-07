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
        Schema::create('clases_cuentas', function (Blueprint $table) {
            $table->id(); 
            $table->string('cod', 10)->unique();  // BCP, INTB, ASTR, SKRI
            $table->string('tipo_clase_cuenta', 50);  // Ahorro, Crédito, Digital, Corriente
            $table->boolean('estado')->default(1);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases_cuentas');
    }
};
