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
        Schema::create('correos_billetera_digital', function (Blueprint $table) {
            $table->id();
            $table->string('correo', 255)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->enum('condicion', ['principal', 'secundario'])->nullable();
            $table->foreignId('cuenta_billetera_digital_id')->constrained('cuentas_billetera_digital');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_billetera_digital');
    }
};
