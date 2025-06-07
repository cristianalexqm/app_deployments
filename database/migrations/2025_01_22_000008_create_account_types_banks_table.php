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
        Schema::create('tipos_cuentas_bancos', function (Blueprint $table) {
            $table->id(); 
            $table->string('cod', 10)->unique();  // Banc, Efec, Linc
            $table->string('tipo_cuenta', 50);  // Banco, Efectivo, LineaCredit
            $table->boolean('estado')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cuentas_bancos');
    }
};
