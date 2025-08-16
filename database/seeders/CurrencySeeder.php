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
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'Dollar Américain',
                'symbol' => '$',
                'is_default' => true,
                'exchange_rate' => 1 // taux d'échange par rapport à USD (lui-même)
            ],
            [
                'code' => 'CDF',
                'name' => 'Franc Congolais',
                'symbol' => 'FC',
                'is_default' => false,
                'exchange_rate' => 2850 // exemple de taux d'échange par rapport à USD
            ],
        ];

        foreach ($currencies as $currencyData) {
            Currency::firstOrCreate(
                ['code' => $currencyData['code']], // Unique key to check
                $currencyData // Data to insert if not found
            );
        }
    }
}
