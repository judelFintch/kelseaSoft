<?php

namespace Database\Factories;

use App\Models\CashRegister;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashRegisterFactory extends Factory
{
    protected $model = CashRegister::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'balance' => 0,
        ];
    }
}
