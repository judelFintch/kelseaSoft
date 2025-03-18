<?php

namespace Database\Factories;

use App\Models\Dossier;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DossierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Dossier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::inRandomOrder()->first()->id ?? Client::factory(),
            'supplier' => $this->faker->company,
            'goods_type' => $this->faker->word,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 100),
            'total_weight' => $this->faker->randomFloat(2, 10, 1000),
            'declared_value' => $this->faker->randomFloat(2, 1000, 100000),
            'fob' => $this->faker->randomFloat(2, 1000, 100000),
            'insurance' => $this->faker->randomFloat(2, 100, 5000),
            'currency' => $this->faker->currencyCode,
            'manifest_number' => $this->faker->bothify('MANI-#####'),
            'container_number' => $this->faker->bothify('CONT-#####'),
            'vehicle_plate' => $this->faker->bothify('XYZ-####'),
            'contract_type' => $this->faker->randomElement(['Import', 'Export']),
            'delivery_place' => $this->faker->address,
            'file_type' => $this->faker->randomElement(['Import Declaration', 'Export Clearance']),
            'expected_arrival_date' => Carbon::now()->addDays($this->faker->numberBetween(5, 20)),
            'border_arrival_date' => Carbon::now()->addDays($this->faker->numberBetween(6, 25)),
            'invoice_number' => $this->faker->bothify('INV-#####'),
            'invoice_date' => Carbon::now()->subDays($this->faker->numberBetween(1, 10)),
            'status' => $this->faker->randomElement(['pending', 'validated', 'completed']),
            'file_number' => $this->faker->unique()->bothify('FILE-2024-####'),
        ];
    }
}
