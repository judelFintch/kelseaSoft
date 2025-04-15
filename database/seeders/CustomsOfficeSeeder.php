<?php

namespace Database\Seeders;
use App\Models\CustomsOffice;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomsOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CustomsOffice::insert([
            ['name' => 'Kasumbalesa'],
            ['name' => 'Matadi Port'],
        ]);
    }
}
