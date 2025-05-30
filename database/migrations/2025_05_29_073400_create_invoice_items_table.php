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
            $table->string('label'); // Exemple : DDI, SEGUCE, CNCT
            $table->enum('category', ['import_tax', 'agency_fee', 'extra_fee']);
            $table->decimal('amount_usd', 12, 2)->default(0); // Montant en USD (référence)

            // Multidevise
            $table->foreignId('currency_id')->nullable();// USD par défaut
            $table->decimal('exchange_rate', 12, 6)->default(1.0); // Taux appliqué au moment de la facture
            $table->decimal('converted_amount', 12, 2)->default(0); // Montant converti (affichage local)

            // Références associées
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
