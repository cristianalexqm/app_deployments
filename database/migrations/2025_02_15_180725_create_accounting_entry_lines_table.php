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
        Schema::create('accounting_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accounting_entry_id')->constrained('accounting_entries')->onDelete('cascade');
            $table->foreignId('accounting_account_id')->constrained('accounting_accounts')->onDelete('cascade');
            $table->decimal('debit', 18, 2)->default(0.00);
            $table->decimal('credit', 18, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounting_entry_lines');
    }
};
