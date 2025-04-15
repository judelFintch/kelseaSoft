<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            DB::table('folders')->insert([
                'folder_number' => 'FD-' . strtoupper(Str::random(6)),
                'truck_number' => 'TRK-' . $faker->randomNumber(4, true),
                'trailer_number' => 'TRL-' . $faker->randomNumber(4, true),
                'transporter_id' => DB::table('transporters')->inRandomOrder()->value('id'),
                'driver_name' => $faker->name,
                'driver_phone' => $faker->phoneNumber,
                'driver_nationality' => $faker->country,
                'origin_id' => DB::table('locations')->inRandomOrder()->value('id'),
                'destination_id' => DB::table('locations')->inRandomOrder()->value('id'),
                'supplier_id' => DB::table('suppliers')->inRandomOrder()->value('id'),
                'client' => $faker->company,
                'customs_office_id' => DB::table('customs_offices')->inRandomOrder()->value('id'),
                'declaration_number' => strtoupper(Str::random(10)),
                'declaration_type_id' => DB::table('declaration_types')->inRandomOrder()->value('id'),
                'declarant' => $faker->name,
                'customs_agent' => $faker->name,
                'container_number' => 'CONT-' . strtoupper(Str::random(6)),
                'weight' => $faker->randomFloat(2, 500, 30000),
                'fob_amount' => $faker->randomFloat(2, 1000, 50000),
                'insurance_amount' => $faker->randomFloat(2, 100, 5000),
                'cif_amount' => $faker->randomFloat(2, 2000, 60000),
                'arrival_border_date' => Carbon::now()->subDays(rand(1, 30)),
                'description' => $faker->sentence(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
