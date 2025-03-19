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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade'); // Lien avec le dossier
            $table->string('name'); // Nom du fichier
            $table->string('path'); // Chemin du fichier
            $table->string('type'); // Type de fichier (PDF, image, etc.)
            $table->integer('size'); // Taille en octets
            $table->timestamps(); // Date d'upload
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
