<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            DB::table('companies')->insert([
                'name' => $faker->company,
                'business_category' => $faker->randomElement(['Import', 'Export', 'Tech', 'Finance', 'Logistics']),
                'tax_id' => strtoupper(Str::random(10)),
                'code' => 'CMP-' . strtoupper(Str::random(5)),
                'national_identification' => strtoupper(Str::random(12)),
                'commercial_register' => 'RC' . $faker->randomNumber(5, true),
                'import_export_number' => 'IE' . $faker->randomNumber(6, true),
                'nbc_number' => 'NBC' . $faker->randomNumber(6, true),
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'physical_address' => $faker->address,
                'status' => $faker->randomElement(['active', 'inactive']),
                'logo' => null,
                'website' => $faker->url,
                'country' => $faker->country,
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
