<?php

namespace Database\Factories;

use App\Models\GlobalInvoice;
use App\Models\Company; // Assuming GlobalInvoice belongs to a Company
use App\Models\User;    // Assuming GlobalInvoice might be created by a User
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalInvoiceFactory extends Factory
{
    protected $model = GlobalInvoice::class;

    public function definition()
    {
        // Basic definition, adjust as per your actual GlobalInvoice model schema
        return [
            'company_id' => Company::factory(),
            'created_by_user_id' => User::factory(),
            'global_invoice_number' => $this->faker->unique()->numerify('GINV-######'),
            'global_invoice_date' => $this->faker->date(),
            'product' => $this->faker->word(),
            'due_date' => $this->faker->optional()->date(),
            'total_amount' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
            'currency_code' => $this->faker->randomElement(['USD', 'EUR', 'CDF']),
            // Add other fields as necessary based on your GlobalInvoice migration
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
