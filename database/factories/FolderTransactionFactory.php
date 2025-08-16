<?php

namespace Database\Factories;

use App\Models\FolderTransaction;
use App\Models\Folder;
use App\Models\Currency;
use App\Models\CashRegister;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderTransactionFactory extends Factory
{
    protected $model = FolderTransaction::class;

    public function definition()
    {
        return [
            'folder_id' => Folder::factory(),
            'cash_register_id' => CashRegister::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency_id' => Currency::factory(),
            'label' => $this->faker->sentence(3),
            'transaction_date' => $this->faker->date(),
        ];
    }
}
