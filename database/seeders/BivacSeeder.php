<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bivac;

class BivacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['label' => 'Contrôle Documentaire'],
            ['label' => 'Inspection Physique'],
        ];

        foreach ($data as $item) {
            $code = strtoupper(str_replace([' ', 'É', 'è', 'é'], ['_', 'E', 'E', 'E'], $item['label']));
            Bivac::firstOrCreate(
                ['code' => $code],
                [
                    'label' => $item['label'],
                    'description' => $item['label'],
                ]
            );
        }
    }
}
