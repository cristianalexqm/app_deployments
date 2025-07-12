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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_trabajador_id')->constrained('tipo_trabajador');
            $table->string('cargo', 100);
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->decimal('reembolso_basico', 10, 2)->nullable();
            $table->string('cups_essalud', 50)->nullable();
            $table->integer('hijos_asignados_familia')->nullable();
            $table->foreignId('tipo_banco_sueldo')->nullable()->constrained('tipos_bancos');
            $table->string('cuenta_banco', 50)->nullable();
            $table->string('cci_banco', 50)->nullable();
            $table->enum('eleccion_fondo', ['AFP', 'ONP']);
            $table->foreignId('tipo_afp_id')->nullable()->constrained('tipo_afp');
            $table->foreignId('tipo_comision_afp_id')->nullable()->constrained('tipo_comision_afp');
            
            $table->foreignId('dato_extra_tipo_entidad_id')->unique()->constrained('tipo_entidades');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
