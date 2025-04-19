<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Licence;


class LicenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            if (!Licence::where('license_number', 'LIC-001')->exists()) {
                Licence::create([
                    'license_number' => 'LIC-001',
                    'license_type' => 'Import',
                    'license_category' => 'Générale',
                    'currency' => 'USD',
    
                    'max_folders' => 5,
                    'remaining_folders' => 5,
                    'initial_weight' => 50000,
                    'remaining_weight' => 50000,
                    'initial_fob_amount' => 500000,
                    'remaining_fob_amount' => 500000,
                    'quantity_total' => 1000,
                    'remaining_quantity' => 1000,
    
                    'freight_amount' => 0,
                    'insurance_amount' => 0,
                    'other_fees' => 0,
                    'cif_amount' => 0,
    
                    'payment_mode' => 'Cash',
                    'payment_beneficiary' => 'Agence X',
                    'transport_mode' => 'Routier',
                    'transport_reference' => 'REF1234',
                    'invoice_date' => now(),
                    'validation_date' => now(),
                    'expiry_date' => now()->addMonths(6),
                    'customs_regime' => 'Régime A',
                    'customs_office_id' => 1,
                    'supplier_id' => 1,
                    'company_id' => 1,
                    'notes' => 'Licence de test',
                ]);
            }
        }
    
    }
}
