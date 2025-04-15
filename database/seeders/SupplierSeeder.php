<?php

namespace Database\Seeders;
use App\Models\Supplier;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Supplier::insert([
            ['name' => 'Mega Supplier', 'phone' => '+243855556666', 'email' => 'supplier@mega.com', 'country' => 'Angola'],
        ]);
    }
}
