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
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Clé étrangère vers la table clients, suppression en cascade
            $table->string('supplier'); // Fournisseur
            $table->string('goods_type'); // Type de marchandises
            $table->text('description')->nullable(); // Description (facultative)
            $table->integer('quantity'); // Quantité
            $table->decimal('total_weight', 10, 2); // Poids total
            $table->decimal('declared_value', 15, 2); // Valeur déclarée
            $table->decimal('fob', 15, 2); // Valeur FOB
            $table->decimal('insurance', 15, 2); // Montant de l'assurance
            $table->string('currency'); // Devise
            $table->string('manifest_number')->nullable(); // Numéro du manifeste (facultatif)
            $table->string('container_number')->nullable(); // Numéro du conteneur (facultatif)
            $table->string('vehicle_plate')->nullable(); // Plaque du véhicule (facultatif)
            $table->string('contract_type'); // Type de contrat
            $table->string('delivery_place')->nullable(); // Lieu de livraison (facultatif)
            $table->string('file_type'); // Type de dossier
            $table->date('expected_arrival_date'); // Date d'arrivée prévue
            $table->date('border_arrival_date')->nullable(); // Date d'arrivée à la frontière (facultatif)
            $table->string('invoice_number')->nullable(); // Numéro de facture (facultatif)
            $table->date('invoice_date')->nullable(); // Date de la facture (facultatif)
            $table->enum('status', ['pending', 'validated', 'completed'])->default('pending'); // Statut du dossier : en attente, validé ou complété
            $table->string('file_number')->unique(); // Numéro de dossier unique
            $table->timestamps(); // Dates de création et de mise à jour
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
