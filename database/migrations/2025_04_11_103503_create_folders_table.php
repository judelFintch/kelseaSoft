<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_number')->unique();

            // Étape 2 Transport
            $table->string('truck_number')->nullable();
            $table->string('trailer_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->foreignId('transporter_id')->nullable()->constrained()->nullOnDelete();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_nationality')->nullable();

            // Étape 1 Origine et Fournisseur
            $table->foreignId('origin_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client')->nullable();

            // Étape 3 Douane
            $table->foreignId('customs_office_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declaration_number')->nullable();
            $table->foreignId('declaration_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('declarant')->nullable();
            $table->string('customs_agent')->nullable();
            $table->string('container_number')->nullable();

            // Valeurs financières
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->decimal('fob_amount', 15, 2)->nullable();
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('cif_amount', 15, 2)->nullable();
            $table->date('arrival_border_date')->nullable();
            $table->text('description')->nullable();

            // Dossier
            $table->string('dossier_type')->default('sans');
            $table->string('license_code')->nullable();
            $table->string('bivac_code')->nullable();
            $table->foreignId('license_id')->nullable()->constrained('licences')->nullOnDelete();
            $table->string('goods_type')->nullable();
            $table->string('agency')->nullable();
            $table->string('pre_alert_place')->nullable();
            $table->string('transport_mode')->nullable();
            $table->string('internal_reference')->nullable();
            $table->string('order_number')->nullable();
            $table->date('folder_date')->nullable();

            // Données complémentaires
            $table->string('tr8_number')->nullable();
            $table->date('tr8_date')->nullable();
            $table->string('t1_number')->nullable();
            $table->date('t1_date')->nullable();
            $table->string('formalities_office_reference')->nullable();
            $table->string('im4_number')->nullable();
            $table->date('im4_date')->nullable();
            $table->string('liquidation_number')->nullable();
            $table->date('liquidation_date')->nullable();
            $table->string('quitance_number')->nullable();
            $table->date('quitance_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
