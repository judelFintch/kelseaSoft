<?php

namespace Database\Factories;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    protected $model = Tax::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lexify('TAX-???'),
            'label' => $this->faker->words(3, true),
        ];
    }
}
