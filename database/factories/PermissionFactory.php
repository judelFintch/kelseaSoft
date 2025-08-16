<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true); // e.g., "edit posts"
        return [
            'name' => Str::slug(str_replace(' ', '_', $name)), // e.g., "edit_posts"
            'display_name' => Str::title($name), // e.g., "Edit Posts"
            'description' => $this->faker->sentence,
        ];
    }
}
