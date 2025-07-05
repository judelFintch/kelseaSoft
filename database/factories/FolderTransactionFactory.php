<?php

namespace Database\Factories;

use App\Models\FolderTransaction;
use App\Models\Folder;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderTransactionFactory extends Factory
{
    protected $model = FolderTransaction::class;

    public function definition()
    {
        return [
            'folder_id' => Folder::factory(),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency_id' => Currency::factory(),
            'label' => $this->faker->sentence(3),
            'transaction_date' => $this->faker->date(),
        ];
    }
}
