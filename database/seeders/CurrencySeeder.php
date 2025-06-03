<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Currency::insert([
            [
            'code' => 'USD',
            'name' => 'Dollar Américain',
            'symbol' => '$',
            'is_default' => true,
            'exchange_rate' => 2850 // taux d'échange par rapport à USD
            ],
            [
            'code' => 'CDF',
            'name' => 'Franc Congolais',
            'symbol' => 'FC',
            'is_default' => false,
            'exchange_rate' => 2850 // exemple de taux d'échange par rapport à USD
            ],
        ]);
    }
}
