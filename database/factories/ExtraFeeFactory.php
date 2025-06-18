<?php

namespace Database\Factories;

use App\Models\ExtraFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraFeeFactory extends Factory
{
    protected $model = ExtraFee::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lexify('EX-???'),
            'label' => $this->faker->words(3, true),
        ];
    }
}
