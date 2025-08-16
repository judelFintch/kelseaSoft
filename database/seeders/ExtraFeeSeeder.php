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
        $feesData = [
            ['label' => 'SEGUCE'],
            ['label' => 'SCELLE Électronique'],
            ['label' => 'NOTE ACCEPTATION (NAC)'],
        ];

        foreach ($feesData as $feeData) {
            $code = strtoupper(str_replace([' ', 'É', '(', ')'], ['_', 'E', '', ''], $feeData['label']));
            ExtraFee::firstOrCreate(
                ['code' => $code], // Unique key to check
                [
                    'label' => $feeData['label'],
                    'description' => $feeData['label'],
                ]
            );
        }
    }
}
