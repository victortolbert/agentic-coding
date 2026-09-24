<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Pin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pin>
 */
class PinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'image_url' => 'https://picsum.photos/seed/'.fake()->unique()->word().'/'.fake()->randomElement([600, 800]).'/'.fake()->randomElement([600, 900, 1200]),
            'note' => fake()->optional()->sentence(6),
        ];
    }
}
