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
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();

            $table->string('label'); // ex: DDI, SEGUCE
            $table->enum('category', ['import_tax', 'agency_fee', 'extra_fee']);
            $table->decimal('amount_usd', 12, 2)->default(0);
            $table->string('currency')->default('USD');

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
