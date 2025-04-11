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
            $table->string('truck_number')->nullable();
            $table->string('trailer_number')->nullable();
            $table->string('transporter')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_nationality')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('supplier')->nullable();
            $table->string('client')->nullable();
            $table->string('customs_office')->nullable();
            $table->string('declaration_number')->nullable();
            $table->string('declaration_type')->nullable();
            $table->string('declarant')->nullable();
            $table->string('customs_agent')->nullable();
            $table->string('container_number')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('fob_amount', 15, 2)->nullable();
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('cif_amount', 15, 2)->nullable();
            $table->date('arrival_border_date')->nullable();
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
