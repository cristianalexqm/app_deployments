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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_banco_id')->nullable()->constrained('tipos_bancos');
            $table->string('cuenta_bancaria', 50)->nullable();
            $table->string('aval', 255)->nullable();
            $table->foreignId('dato_extra_tipo_entidad_id')->unique()->constrained('tipo_entidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
