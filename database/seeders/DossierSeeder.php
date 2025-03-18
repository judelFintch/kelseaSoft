<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dossier;
use App\Models\Client;
use Carbon\Carbon;

class DossierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $client = Client::first(); // Récupère le premier client de la base

        if (!$client) {
            $this->command->warn("No clients found. Please seed the Clients table first.");
            return;
        }

        Dossier::create([
            'client_id' => $client->id,
            'supplier' => 'International Trading Co.',
            'goods_type' => 'Electronics',
            'description' => '50 cartons of mobile phones',
            'quantity' => 50,
            'total_weight' => 500.00,
            'declared_value' => 150000.00,
            'fob' => 140000.00,
            'insurance' => 5000.00,
            'currency' => 'USD',
            'manifest_number' => 'MANI-12345',
            'container_number' => 'CONT-56789',
            'vehicle_plate' => 'XYZ-9876',
            'contract_type' => 'Import',
            'delivery_place' => 'Warehouse #12, New York',
            'file_type' => 'Import Declaration',
            'expected_arrival_date' => Carbon::now()->addDays(10),
            'border_arrival_date' => Carbon::now()->addDays(12),
            'invoice_number' => 'INV-789456',
            'invoice_date' => Carbon::now()->subDays(5),
            'status' => 'pending',
            'file_number' => 'FILE-2024-001'
        ]);

        Dossier::factory(20)->create(); // Génère 20 dossiers aléatoires avec la Factory

    }
}
