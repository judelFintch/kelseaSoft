<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Facture', 'folder_field' => 'invoice_number'],
            ['name' => 'Bill of Lading (B/L)', 'folder_field' => null],
            ['name' => 'Quittance', 'folder_field' => 'quitance_number'],
            ['name' => "Fiche d'identification", 'folder_field' => null],
            ['name' => 'Autre', 'folder_field' => null],
        ];

        foreach ($types as $type) {
            DocumentType::updateOrCreate(
                ['name' => $type['name']],
                ['folder_field' => $type['folder_field']]
            );
        }
    }
}
