<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nationality' => fake()->randomElement(['Colombiano', 'Argentino', 'Chileno']),
            'age' => fake()->numberBetween(20, 40),
            'position' => fake()->randomElement(['Delantero', 'Arquero', 'Medio Campista']),
            'shirt_number' => fake()->unique()->randomNumber(1, 30),
            'photo' => fake()->imageUrl,
        ];
    }
}
