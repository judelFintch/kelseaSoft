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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym')->nullable(); // Acronyme de l'entreprise
            $table->string('business_category')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('code')->nullable();
            $table->string('national_identification')->nullable();
            $table->string('commercial_register')->nullable();
            $table->string('import_export_number')->nullable();
            $table->string('nbc_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('status')->default('active'); // Assuming you want to track the status of the company
            $table->string('logo')->nullable(); // Assuming you want to store the logo of the company
            $table->string('website')->nullable(); // Assuming you want to store the website of the company
            $table->string('country')->nullable(); // Assuming you want to store the country of the company
            $table->boolean('is_deleted')->default(false); // Indicateur de suppression logique

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
