<?php

namespace Database\Seeders;
use App\Models\DocumentType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Facture',
            'Bill of Lading (B/L)',
            'Quittance',
            'Fiche d\'identification',
            'Autre',
        ];
    
        foreach ($types as $type) {
            DocumentType::firstOrCreate(['name' => $type]);
        }
    }
}
