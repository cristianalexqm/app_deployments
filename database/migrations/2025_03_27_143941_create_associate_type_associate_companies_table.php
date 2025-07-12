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
        Schema::create('associate_type_associate_companies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associate_type_associate_id')->constrained('asociado_tipo_asociado')->cascadeOnDelete();
            $table->foreignId('own_company_id')->constrained('empresa_propia')->cascadeOnDelete();
            $table->boolean('estado')->default(true);

            $table->timestamps();

            $table->unique(['associate_type_associate_id', 'own_company_id'], 'unique_associate_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associate_type_associate_companies');
    }
};
