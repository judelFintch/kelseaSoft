<?php

namespace Database\Factories;

use App\Models\AgencyFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFeeFactory extends Factory
{
    protected $model = AgencyFee::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lexify('AGE-???'),
            'label' => $this->faker->words(3, true),
        ];
    }
}
