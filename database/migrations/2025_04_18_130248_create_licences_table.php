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
        Schema::create('licences', function (Blueprint $table) {
            $table->id();
            $table->string('license_number')->unique();
            $table->string('license_type');
            $table->string('license_category')->nullable();
            $table->string('currency')->default('USD');

            // Capacités autorisées
            $table->integer('max_folders')->default(1);
            $table->integer('remaining_folders')->default(1);
            $table->float('initial_weight')->default(0);
            $table->float('remaining_weight')->default(0);
            $table->float('initial_fob_amount')->default(0);
            $table->float('remaining_fob_amount')->default(0);
            $table->float('quantity_total')->default(0);
            $table->float('remaining_quantity')->default(0);

            // Financier
            $table->float('freight_amount')->nullable();
            $table->float('insurance_amount')->nullable();
            $table->float('other_fees')->nullable();
            $table->float('cif_amount')->nullable();

            $table->string('payment_mode')->nullable();
            $table->string('payment_beneficiary')->nullable();
            $table->string('transport_mode')->nullable();
            $table->string('transport_reference')->nullable();

            $table->date('invoice_date')->nullable();
            $table->date('validation_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('customs_regime')->nullable();

            $table->foreignId('customs_office_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licences');
    }
};
