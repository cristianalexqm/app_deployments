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
        Schema::create('company_associate_accounting', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('accounting_account_id')->constrained('accounting_accounts');
            // $table->foreignId('associate_type_associate_company_id')->constrained('associate_type_associate_companies');  
            $table->foreignId('associate_company_id')->nullable()->constrained('associate_companies')->onDelete('set null');
 

            // $table->unique([ 'accounting_account_id', 'associate_type_associate_company_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_associate_accounting');
    }
};
