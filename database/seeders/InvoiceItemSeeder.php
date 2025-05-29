<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceItem;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoiceId = 1; // Assurez-vous que cette facture existe

        $items = [
            // Taxes
            ['label' => 'Droits de Douanes à l’Import', 'category' => 'import_tax', 'amount_usd' => 381.94, 'tax_id' => 1],
            ['label' => 'Droit d’accise à l’Import', 'category' => 'import_tax', 'amount_usd' => 0.00, 'tax_id' => 2],
            ['label' => 'Redevance Logistique Terrestre', 'category' => 'import_tax', 'amount_usd' => 255.00, 'tax_id' => 3],
            ['label' => 'Taxe contrôle Produits Toxiques', 'category' => 'import_tax', 'amount_usd' => 216.00, 'tax_id' => 4],
            ['label' => 'Taxe Promotion de l’Industrie', 'category' => 'import_tax', 'amount_usd' => 147.58, 'tax_id' => 5],
            ['label' => 'Commission OGEFREM', 'category' => 'import_tax', 'amount_usd' => 38.19, 'tax_id' => 6],
            ['label' => 'Redevance Informatique DGDA', 'category' => 'import_tax', 'amount_usd' => 171.87, 'tax_id' => 7],
            ['label' => 'Frais Labo OCC + Retenue OCC', 'category' => 'import_tax', 'amount_usd' => 118.56, 'tax_id' => 8],
            ['label' => 'Rétribution DGDA Partenaires', 'category' => 'import_tax', 'amount_usd' => 6.25, 'tax_id' => 9],
            ['label' => 'Retenue ANAPI', 'category' => 'import_tax', 'amount_usd' => 8.02, 'tax_id' => 10],

            // Frais d’agence
            ['label' => 'Frais Techniques', 'category' => 'agency_fee', 'amount_usd' => 150.00, 'agency_fee_id' => 1],
            ['label' => 'Couts Internes', 'category' => 'agency_fee', 'amount_usd' => 150.00, 'agency_fee_id' => 2],
            ['label' => 'Honoraires', 'category' => 'agency_fee', 'amount_usd' => 200.00, 'agency_fee_id' => 3],
            ['label' => 'TVA', 'category' => 'agency_fee', 'amount_usd' => 80.00, 'agency_fee_id' => 4],

            // Frais divers
            ['label' => 'SEGUCE', 'category' => 'extra_fee', 'amount_usd' => 120.00, 'extra_fee_id' => 1],
            ['label' => 'SCELLE Électronique', 'category' => 'extra_fee', 'amount_usd' => 60.00, 'extra_fee_id' => 2],
            ['label' => 'NOTE ACCEPTATION (NAC)', 'category' => 'extra_fee', 'amount_usd' => 15.00, 'extra_fee_id' => 3],
        ];

        foreach ($items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoiceId,
                'label' => $item['label'],
                'category' => $item['category'],
                'amount_usd' => $item['amount_usd'],
                'currency_id' => 1, // USD
                'exchange_rate' => 1.0,
                'converted_amount' => $item['amount_usd'],
                'tax_id' => $item['tax_id'] ?? null,
                'agency_fee_id' => $item['agency_fee_id'] ?? null,
                'extra_fee_id' => $item['extra_fee_id'] ?? null,
            ]);
        }
    }
}
