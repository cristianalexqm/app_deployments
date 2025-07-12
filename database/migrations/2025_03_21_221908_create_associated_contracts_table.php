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
        Schema::create('associated_contracts', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_contrato', 15, 2);
            $table->decimal('asociado', 15, 2);
            $table->decimal('asociante', 15, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('dias_contrato');
            $table->date('fecha_firma');
            $table->timestamps();


            $table->foreignId('asociado_tipo_asociado_id')->constrained('asociado_tipo_asociado')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associated_contracts');
    }
};
