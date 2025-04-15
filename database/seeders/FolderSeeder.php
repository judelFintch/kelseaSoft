<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Enums\DossierType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Folder::create([
            'folder_number' => 'FD-' . strtoupper(Str::random(8)),
            'truck_number' => 'TRK-123',
            'trailer_number' => 'TRL-456',
            'invoice_number' => 'INV-789',

            'transporter_id' => 1,
            'driver_name' => 'Jean Chauffeur',
            'driver_phone' => '0999000111',
            'driver_nationality' => 'Congolaise',

            'origin_id' => 1,
            'destination_id' => 2,
            'supplier_id' => 1,
            'client' => 'Client Exemple',
            'customs_office_id' => 1,
            'declaration_number' => 'DECL-0001',
            'declaration_type_id' => 1,
            'declarant' => 'Agent Kabila',
            'customs_agent' => 'Douanier Mbayo',
            'container_number' => 'CONT-001',

            'weight' => 15000.75,
            'fob_amount' => 120000.00,
            'insurance_amount' => 2500.00,
            'cif_amount' => 122500.00,
            'arrival_border_date' => now()->subDays(2),
            'description' => 'Dossier test pour développement.',

            'dossier_type' => DossierType::AVEC->value,
            'license_code' => 'LIC-001',
            'bivac_code' => 'BIV-001',
        ]);
    }
}
