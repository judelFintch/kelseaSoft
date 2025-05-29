<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\ExtraFee;

class ExtraFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $usd = 1;

        $fees = [
            ['label' => 'SEGUCE', 'default_amount' => 120],
            ['label' => 'SCELLE Électronique', 'default_amount' => 60],
            ['label' => 'NOTE ACCEPTATION (NAC)', 'default_amount' => 15],
        ];

        foreach ($fees as $fee) {
            ExtraFee::create([
                'label' => $fee['label'],
                'default_amount' => $fee['default_amount'],
                'currency_id' => $usd,
                'exchange_rate' => 1.0,
                'default_converted_amount' => $fee['default_amount'],
            ]);
        }
    }
}
