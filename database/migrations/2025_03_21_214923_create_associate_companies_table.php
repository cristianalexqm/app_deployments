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
        Schema::create('associate_companies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('associated_id')->constrained('asociado');
            $table->foreignId('own_company_id')->constrained('empresa_propia');
            // $table->foreignId('estado')->constrained('status_assignment_associated_companies');
            $table->boolean('estado')->default(true);
            $table->unique(['associated_id', 'own_company_id']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associate_companies');
    }
};
