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
    $fees = [
        ['label' => 'SEGUCE'],
        ['label' => 'SCELLE Électronique'],
        ['label' => 'NOTE ACCEPTATION (NAC)'],
    ];

    foreach ($fees as $fee) {
        ExtraFee::create([
        'label' => $fee['label'],
        'code' => strtoupper(str_replace(' ', '_', $fee['label'])),
        'description' => $fee['label'],
        ]);
    }
    }
}
