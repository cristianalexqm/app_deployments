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
        Schema::create('tipos_bancos', function (Blueprint $table) {
            $table->id(); 
            $table->string('cod', 10)->unique();  // BCP, INTB
            $table->string('tipo_banco', 50);  // Bcp, Interbank
            $table->enum('tipo_recurso', ["FIAT", "CRIPTO", "BILLETERA"]);
            $table->foreignId('tipos_cuentas_bancos_id')->constrained('tipos_cuentas_bancos')->onDelete('cascade');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_bancos');
    }
};
