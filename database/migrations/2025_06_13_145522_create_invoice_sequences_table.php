<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('invoice_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['normal', 'global']);
            $table->unsignedBigInteger('current_number')->default(0);
            $table->timestamps();

            $table->unique(['company_id', 'type']); // Garantie d’unicité par entreprise et par type
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_sequences');
    }
};
