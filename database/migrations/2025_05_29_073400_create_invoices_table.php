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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('operation_code')->nullable();
            $table->string('product')->nullable(); // Produit facturé (Houille, MGO, etc.)
            $table->string('weight')->nullable(); // Exemple : "38T"
            $table->decimal('fob_amount', 12, 2)->nullable();
            $table->decimal('insurance_amount', 12, 2)->nullable();
            $table->decimal('freight_amount', 12, 2)->nullable();
            $table->decimal('cif_amount', 12, 2)->nullable();
            $table->date('invoice_date');
            $table->enum('payment_mode', ['provision', 'cash', 'transfer'])->default('provision');
            $table->decimal('total_usd', 12, 2)->default(0);
            $table->decimal('default_amount', 10, 2)->nullable();
            $table->foreignId('currency_id')->default(1)->constrained(); // USD = 1
            $table->decimal('exchange_rate', 12, 4)->default(1.0); // par rapport à USD
            $table->decimal('converted_total', 12, 2)->nullable(); // Montant dans la devise choisie
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
