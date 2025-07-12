<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounting_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('code', 20)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            $table->boolean('sports_trading')->nullable();
            $table->boolean('accounting_type')->nullable();

            $table->enum('level', ['Balance', 'Sub-Cuenta', 'Registro']);
            $table->boolean('is_base')->default(false);
            $table->string('debit_linked_account')->nullable();
            $table->string('credit_linked_account')->nullable();
            
            $table->foreignId('currency_id')->nullable()->constrained('monedas');
            $table->foreignId('category_id')->constrained('categories');
            
            // $table->foreignId('own_company_id')->nullable()->constrained('own_companies');
            $table->foreignId('own_company_id')->nullable()->constrained('empresa_propia')->onDelete('restrict');
            $table->foreignId('parent_id')->nullable()->constrained('accounting_accounts')->onDelete('restrict');



            $table->timestamps();

            $table->index('code');
            $table->index('category_id');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('accounting_accounts');
    }
};
