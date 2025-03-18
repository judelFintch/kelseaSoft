<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Client::create([
            'company_name' => 'Global Logistics Ltd',
            'contact_person' => 'John Doe',
            'email' => 'contact@globallogistics.com',
            'phone' => '+1234567890',
            'secondary_phone' => '+0987654321',
            'address' => '123 Business St, New York, USA',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'tax_id' => 'TAX123456',
            'registration_number' => 'REG-987654',
            'identification_number' => 'ID-654321',
            'rccm' => 'RCCM-2024-56789',
            'website' => 'https://globallogistics.com',
            'notes' => 'Preferred client for high-value shipments'
        ]);

        Client::factory(10)->create(); 
    }
}
