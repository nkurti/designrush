<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $faker->company,
            'description' => $faker->paragraph,
            'logo' => 'logos/' . $faker->image('storage/app/public/logos', 200, 200, null, false),
            'category_id' => Category::factory(),
        ];
    }
}
