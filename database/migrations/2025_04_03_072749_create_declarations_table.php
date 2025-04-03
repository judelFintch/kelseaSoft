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
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->string('numero_e')->unique(); // Numéro E (sans la lettre)
            $table->date('date_e');

            $table->foreignId('importateur_id')->constrained('clients');
            $table->foreignId('exportateur_id')->nullable()->constrained('clients');

            $table->string('regime'); // IM4, EX1, etc.
            $table->string('bureau_douane');

            $table->string('pays_provenance');
            $table->string('pays_destination');

            $table->decimal('taux_change', 15, 4)->nullable();

            $table->foreignId('declarant_id')->nullable()->constrained('users');

            $table->string('numero_conteneur')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
