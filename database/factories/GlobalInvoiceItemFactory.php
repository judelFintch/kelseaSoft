<?php

namespace Database\Factories;

use App\Models\GlobalInvoiceItem;
use App\Models\GlobalInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class GlobalInvoiceItemFactory extends Factory
{
    protected $model = GlobalInvoiceItem::class;

    public function definition()
    {
        return [
            'global_invoice_id' => GlobalInvoice::factory(),
            'category' => $this->faker->randomElement(['import_tax', 'agency_fee', 'extra_fee']),
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $this->faker->randomFloat(2, 10, 500),
            'total_price' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['unit_price'];
            },
            'original_item_ids' => [],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
