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
        Schema::create('global_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('global_invoice_id')->constrained()->onDelete('cascade')->index();
            $table->enum('category', ['import_tax', 'agency_fee', 'extra_fee']);
            $table->string('description');
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->json('original_item_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_invoice_items');
    }
};
