<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\Company;
use App\Models\User;
use App\Models\Transporter;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\CustomsOffice;
use App\Models\DeclarationType;
use App\Models\Licence;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderFactory extends Factory
{
    protected $model = Folder::class;

    public function definition()
    {
        return [
            'folder_number' => $this->faker->unique()->numerify('FOLDER-####'),
            'truck_number' => $this->faker->bothify('??####?'), // Example truck number
            'trailer_number' => $this->faker->optional()->bothify('??####?'),
            'invoice_number' => $this->faker->optional()->numerify('INV-#####'),
            'transporter_id' => Transporter::factory(),
            'driver_name' => $this->faker->optional()->name,
            'driver_phone' => $this->faker->optional()->phoneNumber,
            'driver_nationality' => $this->faker->optional()->countryCode,
            'origin_id' => Location::factory(),
            'destination_id' => Location::factory(),
            'supplier_id' => Supplier::factory(),
            'client' => $this->faker->optional()->company,
            'customs_office_id' => CustomsOffice::factory(),
            'declaration_number' => $this->faker->optional()->numerify('DEC-#####'),
            'declaration_type_id' => DeclarationType::factory(),
            'declarant' => $this->faker->optional()->name,
            'customs_agent' => $this->faker->optional()->name,
            'container_number' => $this->faker->optional()->bothify('???U#######'),
            'weight' => $this->faker->optional()->randomFloat(2, 1000, 25000),
            'quantity' => $this->faker->optional()->numberBetween(1, 100),
            'fob_amount' => $this->faker->optional()->randomFloat(2, 1000, 100000),
            'insurance_amount' => $this->faker->optional()->randomFloat(2, 100, 5000),
            'freight_amount' => $this->faker->optional()->randomFloat(2, 100, 5000),
            'cif_amount' => $this->faker->optional()->randomFloat(2, 1100, 105000),
            'currency_id' => Currency::factory(),
            'arrival_border_date' => $this->faker->optional()->date(),
            'description' => $this->faker->paragraph,
            'dossier_type' => $this->faker->randomElement(['sans', 'avec_licence']), // Example types
            'license_code' => $this->faker->optional()->numerify('LIC-#####'),
            'bivac_code' => $this->faker->optional()->numerify('BVC-#####'),
            'license_id' => null, // Or Licence::factory() if it should always exist or be created
            'goods_type' => $this->faker->optional()->word,
            'agency' => $this->faker->optional()->company,
            'pre_alert_place' => $this->faker->optional()->city,
            'transport_mode' => $this->faker->optional()->randomElement(['road', 'air', 'sea']),
            'internal_reference' => $this->faker->optional()->numerify('INTREF-####'),
            'order_number' => $this->faker->optional()->numerify('ORD-#####'),
            'folder_date' => $this->faker->optional()->date(),
            'tr8_number' => $this->faker->optional()->numerify('TR8-#####'),
            'tr8_date' => $this->faker->optional()->date(),
            't1_number' => $this->faker->optional()->numerify('T1-#####'),
            't1_date' => $this->faker->optional()->date(),
            'formalities_office_reference' => $this->faker->optional()->numerify('FORREF-####'),
            'im4_number' => $this->faker->optional()->numerify('IM4-#####'),
            'im4_date' => $this->faker->optional()->date(),
            'liquidation_number' => $this->faker->optional()->numerify('LIQ-#####'),
            'liquidation_date' => $this->faker->optional()->date(),
            'quitance_number' => $this->faker->optional()->numerify('QUIT-#####'),
            'quitance_date' => $this->faker->optional()->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
