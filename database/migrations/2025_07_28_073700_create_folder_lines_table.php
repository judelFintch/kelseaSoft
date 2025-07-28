<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folder_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->onDelete('cascade');
            $table->string('position_code')->nullable();
            $table->string('description')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('colis')->nullable();
            $table->string('emballage')->nullable();
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->decimal('net_weight', 10, 2)->nullable();
            $table->decimal('fob_amount', 15, 2)->nullable();
            $table->string('license_code')->nullable();
            $table->string('fxi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folder_lines');
    }
};
