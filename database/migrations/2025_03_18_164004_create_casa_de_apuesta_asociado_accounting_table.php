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
        Schema::create('casa_de_apuesta_asociado_accounting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('casa_de_apuesta_id');
            $table->unsignedBigInteger('asociado_tipo_asociado_id');
            $table->unsignedBigInteger('accounting_account_id');

            $table->foreign('casa_de_apuesta_id')->references('id')->on('casa_de_apuesta_moneda')->onDelete('cascade');
            $table->foreign('asociado_tipo_asociado_id')->references('id')->on('asociado_tipo_asociado')->onDelete('cascade');
            $table->foreign('accounting_account_id')->references('id')->on('accounting_accounts')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casa_de_apuesta_asociado_accounting');
    }
};
