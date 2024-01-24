<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position' => fake()->randomElement(['back', 'front', 'middle']),
            'name' => fake()->name(),
            'back_number' => fake()->randomElement([10,11,12]),
            'created_by' => fake()->randomElement([1,2,3]),
            'created_date' => now()
        ];
    }
}
