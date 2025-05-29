<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\AgencyFee;

class AgencyFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usd = 1;

        $fees = [
            ['label' => 'Frais Techniques', 'default_amount' => 150],
            ['label' => 'Couts Internes', 'default_amount' => 150],
            ['label' => 'Honoraires', 'default_amount' => 200],
            ['label' => 'TVA', 'default_amount' => 80],
        ];

        foreach ($fees as $fee) {
            AgencyFee::create([
                'label' => $fee['label'],
                'default_amount' => $fee['default_amount'],
                'currency_id' => $usd,
                'exchange_rate' => 1.0,
                'default_converted_amount' => $fee['default_amount'],
            ]);
        }
    }
}
