<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgencyFee;

class AgencyFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['label' => 'Frais Techniques', 'description' => 'Frais liés aux aspects techniques'],
            ['label' => 'Couts Internes', 'description' => 'Coûts internes de gestion'],
            ['label' => 'Honoraires', 'description' => 'Honoraires de l\'agence'],
            ['label' => 'TVA', 'description' => 'Taxe sur la valeur ajoutée'],
        ];

        foreach ($fees as $fee) {
            AgencyFee::updateOrCreate(
                ['code' => str_replace(' ', '_', strtolower($fee['label']))],
                [
                    'label' => $fee['label'],
                    'description' => $fee['description'],
                ]
            );
        }
    }
}
