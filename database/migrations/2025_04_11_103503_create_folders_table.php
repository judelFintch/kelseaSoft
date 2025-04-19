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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_number')->unique();
            $table->string('truck_number');
            $table->string('trailer_number')->nullable();
            $table->string('invoice_number')->nullable();

            $table->foreignId('transporter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_nationality')->nullable();

            $table->foreignId('origin_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client')->nullable();

            $table->foreignId('customs_office_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declaration_number')->nullable();
            $table->foreignId('declaration_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declarant')->nullable();
            $table->string('customs_agent')->nullable();
            $table->string('container_number')->nullable();

            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('fob_amount', 15, 2)->nullable();
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('cif_amount', 15, 2)->nullable();
            $table->date('arrival_border_date')->nullable();
            $table->text('description')->nullable();

            $table->string('dossier_type')->default('sans'); 
            $table->string('license_code')->nullable(); 
            $table->string('bivac_code')->nullable();
            $table->foreignId('license_id')->nullable()->constrained('licences')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
