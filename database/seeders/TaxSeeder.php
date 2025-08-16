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
        $taxesData = [
            ['code' => 'DDI', 'label' => 'Droits de Douanes à l’Import'],
            ['code' => 'DAI', 'label' => 'Droit d’accise à l’Import'],
            ['code' => 'RLT', 'label' => 'Redevance Logistique Terrestre'],
            ['code' => 'TCPT', 'label' => 'Taxe contrôle Produits Toxiques'],
            ['code' => 'TPI', 'label' => 'Taxe Promotion de l’Industrie'],
            ['code' => 'OGEFREM', 'label' => 'Commission OGEFREM'],
            ['code' => 'DGDAINF', 'label' => 'Redevance Informatique DGDA'],
            ['code' => 'OCCLAB', 'label' => 'Frais Labo OCC + Retenue OCC'],
            ['code' => 'DGDAREP', 'label' => 'Rétribution DGDA Partenaires'],
            ['code' => 'ANAPI', 'label' => 'Retenue ANAPI'],
        ];

        foreach ($taxesData as $taxData) {
            Tax::firstOrCreate(
                ['code' => $taxData['code']], // Unique key to check
                $taxData // Data to insert if not found
            );
        }
    }
}
