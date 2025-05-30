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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            // Lien vers la facture
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();

            // Informations principales
            $table->string('label');
            $table->enum('category', ['import_tax', 'agency_fee', 'extra_fee']);

            // Montants
            $table->decimal('amount_usd', 12, 2)->default(0); // Référence USD
            $table->decimal('amount_cdf', 14, 2)->default(0); // Montant converti CDF

            // Devise utilisée
            $table->foreignId('currency_id')->nullable();
            $table->decimal('exchange_rate', 12, 6)->default(1.0);

            // Références
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agency_fee_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('extra_fee_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
