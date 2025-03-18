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
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to clients
            $table->string('supplier');
            $table->string('goods_type');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('total_weight', 10, 2);
            $table->decimal('declared_value', 15, 2);
            $table->decimal('fob', 15, 2);
            $table->decimal('insurance', 15, 2);
            $table->string('currency');
            $table->string('manifest_number')->nullable();
            $table->string('container_number')->nullable();
            $table->string('vehicle_plate')->nullable();
            $table->string('contract_type');
            $table->string('delivery_place')->nullable();
            $table->string('file_type');
            $table->date('expected_arrival_date');
            $table->date('border_arrival_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->enum('status', ['pending', 'validated', 'completed'])->default('pending');
            $table->string('file_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};
