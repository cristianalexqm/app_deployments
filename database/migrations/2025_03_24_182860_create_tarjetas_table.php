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
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banco_emisor_id')->constrained('tipos_tarjetas');
            $table->string('numero_tarjeta', 16)->unique();
            $table->string('cvv', 4);
            $table->date('fecha_expiracion');
            $table->string('clave_cajero', 4);
            $table->enum('producto_financiero', ['debito', 'credito']);
            $table->decimal('linea_credito', 10, 2)->nullable();
            $table->string('fecha_corte', 50)->nullable();
            $table->string('fecha_vencimiento', 50)->nullable();
            $table->foreignId('banco_acceso_id')->nullable()->constrained('banco_acceso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas');
    }
};
