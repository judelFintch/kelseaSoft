<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\Company;
use App\Enums\DossierType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FolderSeeder extends Seeder
{
    public function run(): void
    {
        // ⚠️ Crée une entreprise si elle n’existe pas encore
        $company = Company::firstOrCreate([
            'code' => 'ENT-001',
        ], [
            'name' => 'Entreprise Exemple SARL',
            'acronym' => 'EXS',
            'business_category' => 'Import-Export',
            'tax_id' => 'CD123456789',
            'national_identification' => 'NAT123456789',
            'commercial_register' => 'RCCM/CD/123/2020',
            'import_export_number' => 'IE123456',
            'nbc_number' => 'NBC-789456',
            'phone_number' => '+243899001122',
            'email' => 'contact@entreprise-exemple.cd',
            'physical_address' => '1, Boulevard du Commerce, Kinshasa',
            'is_deleted' => false,
        ]);

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
            'quantity' => 100,
            'fob_amount' => 120000.00,
            'insurance_amount' => 2500.00,
            'cif_amount' => 122500.00,
            'arrival_border_date' => now()->subDays(2),
            'description' => 'Dossier test pour développement.',

            'dossier_type' => DossierType::AVEC->value,
            'license_code' => 'LIC-001',
            'bivac_code' => 'BIV-001',
            'license_id' => 1,

            // 🔗 Lien avec la société créée
            'company_id' => $company->id,
        ]);
    }
}
