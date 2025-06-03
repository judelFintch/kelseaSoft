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
        Schema::create('global_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('global_invoice_number')->unique();
            $table->foreignId('company_id')->nullable()->constrained()->index();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('global_invoices');
    }
};
