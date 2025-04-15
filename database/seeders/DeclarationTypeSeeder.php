<?php

namespace Database\Seeders;
use App\Models\DeclarationType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeclarationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DeclarationType::insert([
            ['name' => 'Import'],
            ['name' => 'Export'],
            ['name' => 'Transit'],
        ]);
    }
}
