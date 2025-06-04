<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'acronym' => $this->faker->lexify('???'), // Example for acronym
            'business_category' => $this->faker->bs,
            'tax_id' => $this->faker->unique()->numerify('NIF-#####'), // NIF
            'code' => $this->faker->unique()->ean8, // Example for code
            'national_identification' => $this->faker->unique()->numerify('IDNAT-#####'), // ID NAT
            'commercial_register' => $this->faker->unique()->numerify('RCCM-#####'), // RCCM
            'import_export_number' => $this->faker->unique()->numerify('IE-#####'),
            'nbc_number' => $this->faker->unique()->numerify('NBC-#####'),
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'physical_address' => $this->faker->address,
            'status' => 'active',
            'logo' => null, // or $this->faker->imageUrl(200, 200, 'business') if you want placeholder images
            'website' => $this->faker->optional()->domainName,
            'country' => $this->faker->countryCode,
            'is_deleted' => false,
        ];
    }
}
