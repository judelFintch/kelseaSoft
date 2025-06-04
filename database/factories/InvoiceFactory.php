<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Folder; // Assuming Invoice belongs to a Folder
use App\Models\Company; // Assuming Invoice may also relate to a Company directly or via Folder
use App\Models\User;    // Assuming Invoice might be created by a User
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        // Basic definition, adjust as per your actual Invoice model schema and relationships
        return [
            'folder_id' => Folder::factory(), // Or a specific existing folder
            'company_id' => Company::factory(), // Or determined via folder->company_id
            'created_by_user_id' => User::factory(), // Or a specific existing user
            'invoice_number' => $this->faker->unique()->numerify('INV-######'),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->optional()->date(),
            'total_amount' => $this->faker->randomFloat(2, 50, 5000),
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'cancelled']),
            'currency_code' => $this->faker->randomElement(['USD', 'EUR', 'CDF']),
            // Add other fields as necessary based on your Invoice migration
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
