<?php
namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company,
            'contact_person' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'secondary_phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'tax_id' => $this->faker->unique()->bothify('TAX-#####'),
            'registration_number' => $this->faker->unique()->bothify('REG-#####'),
            'identification_number' => $this->faker->unique()->bothify('ID-#####'),
            'rccm' => $this->faker->unique()->bothify('RCCM-####-#####'),
            'website' => $this->faker->url,
            'notes' => $this->faker->sentence,
        ];
    }
}
