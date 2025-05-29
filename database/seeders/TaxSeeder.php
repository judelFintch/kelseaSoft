<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usd = 1;

        $taxes = [
            ['code' => 'DDI', 'label' => 'Droits de Douanes à l’Import', 'default_amount' => 381.94],
            ['code' => 'DAI', 'label' => 'Droit d’accise à l’Import', 'default_amount' => 0],
            ['code' => 'RLT', 'label' => 'Redevance Logistique Terrestre', 'default_amount' => 255],
            ['code' => 'TCPT', 'label' => 'Taxe contrôle Produits Toxiques', 'default_amount' => 216],
            ['code' => 'TPI', 'label' => 'Taxe Promotion de l’Industrie', 'default_amount' => 147.58],
            ['code' => 'OGEFREM', 'label' => 'Commission OGEFREM', 'default_amount' => 38.19],
            ['code' => 'DGDAINF', 'label' => 'Redevance Informatique DGDA', 'default_amount' => 171.87],
            ['code' => 'OCCLAB', 'label' => 'Frais Labo OCC + Retenue OCC', 'default_amount' => 118.56],
            ['code' => 'DGDAREP', 'label' => 'Rétribution DGDA Partenaires', 'default_amount' => 6.25],
            ['code' => 'ANAPI', 'label' => 'Retenue ANAPI', 'default_amount' => 8.02],
        ];

        foreach ($taxes as $tax) {
            Tax::create([
                'code' => $tax['code'],
                'label' => $tax['label'],
                'default_amount' => $tax['default_amount'],
                'currency_id' => $usd,
                'exchange_rate' => 1.0,
                'default_converted_amount' => $tax['default_amount'],
            ]);
        }
    }
}
