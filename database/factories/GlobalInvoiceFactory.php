<?php

namespace Database\Factories;

use App\Models\GlobalInvoice;
use App\Models\Company; // Assuming GlobalInvoice belongs to a Company
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalInvoiceFactory extends Factory
{
    protected $model = GlobalInvoice::class;

    public function definition()
    {
        // Basic definition, adjust as per your actual GlobalInvoice model schema
        return [
            'company_id' => Company::factory(),
            'global_invoice_number' => $this->faker->unique()->numerify('GINV-######'),
            'product' => $this->faker->word(),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->optional()->date(),
            'total_amount' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => $this->faker->randomElement(['pending', 'paid']),
            'notes' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
