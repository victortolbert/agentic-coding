<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => Str::title(rtrim(fake()->sentence(3), '.')),
            'description' => fake()->optional()->sentence(),
        ];
    }

    /**
     * A board with a public link.
     */
    public function shared(): static
    {
        return $this->state(fn (array $attributes) => [
            'share_token' => Str::random(40),
        ]);
    }
}
