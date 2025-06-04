<?php

namespace Database\Factories;

use App\Models\GlobalInvoiceItem;
use App\Models\GlobalInvoice;
use App\Models\Invoice; // Assuming a global invoice item links to a regular invoice
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalInvoiceItemFactory extends Factory
{
    protected $model = GlobalInvoiceItem::class;

    public function definition()
    {
        return [
            'global_invoice_id' => GlobalInvoice::factory(),
            'invoice_id' => Invoice::factory(), // Link to an individual invoice
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
            'total_amount' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['unit_price'];
            },
            // Add other fields as necessary based on your GlobalInvoiceItem migration
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
