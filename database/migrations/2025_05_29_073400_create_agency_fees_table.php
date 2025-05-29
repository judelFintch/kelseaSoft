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
        Schema::create('agency_fees', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // NOM du frais
            $table->decimal('default_amount', 12, 2)->default(0); // Montant par défaut en USD

            // Multidevise
            $table->foreignId('currency_id')->constrained()->default(1); // USD par défaut
            $table->decimal('exchange_rate', 12, 6)->default(1.0);
            $table->decimal('default_converted_amount', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_fees');
    }
};
