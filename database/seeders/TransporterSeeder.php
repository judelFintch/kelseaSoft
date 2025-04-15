<?php

namespace Database\Seeders;

use App\Models\Transporter;
use Illuminate\Database\Seeder;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Transporter::insert([
            ['name' => 'Transco', 'phone' => '+243811112222', 'email' => 'contact@transco.com', 'country' => 'DR Congo'],
            ['name' => 'LogistiTech', 'phone' => '+243822223333', 'email' => 'info@logistitech.cd', 'country' => 'DR Congo'],
        ]);
    }
}
