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
            Licence::create([
                'license_number' => 'LIC-' . strtoupper(Str::random(6)),
                'license_type' => fake()->randomElement(['Import', 'Export']),
                'license_category' => fake()->randomElement(['A', 'B', 'C']),
                'currency' => 'USD',

                'max_folders' => $max = fake()->numberBetween(3, 10),
                'remaining_folders' => $max,

                'initial_weight' => $weight = fake()->randomFloat(2, 1000, 5000),
                'remaining_weight' => $weight,

                'initial_fob_amount' => $fob = fake()->randomFloat(2, 10000, 50000),
                'remaining_fob_amount' => $fob,

                'quantity_total' => $qty = fake()->randomFloat(2, 100, 500),
                'remaining_quantity' => $qty,

                'freight_amount' => fake()->randomFloat(2, 100, 500),
                'insurance_amount' => fake()->randomFloat(2, 50, 300),
                'other_fees' => fake()->randomFloat(2, 10, 100),
                'cif_amount' => $fob + 200 + 300 + 100,

                'payment_mode' => fake()->randomElement(['Bank Transfer', 'Cash']),
                'payment_beneficiary' => fake()->company,
                'transport_mode' => fake()->randomElement(['Maritime', 'Aérien', 'Routier']),
                'transport_reference' => strtoupper(Str::random(8)),

                'invoice_date' => now()->subDays(rand(10, 30)),
                'validation_date' => now()->subDays(rand(5, 10)),
                'expiry_date' => now()->addMonths(6),
                'customs_regime' => fake()->randomElement(['Régime 42', 'Régime 48']),

                'customs_office_id' => 1,
                'supplier_id' => 1,
                'company_id' => 1,

                'notes' => fake()->sentence(),
            ]);
        }
    
    }
}
