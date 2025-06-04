<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        $name = $this->faker->unique()->word;
        return [
            'name' => Str::slug($name),
            'display_name' => Str::title($name),
            'description' => $this->faker->sentence,
        ];
    }
}
