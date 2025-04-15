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
            $table->string('folder_number');
            $table->string('truck_number');
            $table->string('trailer_number');
            $table->foreignId('transporter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('driver_nationality');
            $table->foreignId('origin_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client');
            $table->foreignId('customs_office_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declaration_number');
            $table->foreignId('declaration_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declarant');
            $table->string('customs_agent');
            $table->string('container_number');
            $table->float('weight');
            $table->float('fob_amount');
            $table->float('insurance_amount');
            $table->float('cif_amount');
            $table->date('arrival_border_date');
            $table->text('description')->nullable();
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
