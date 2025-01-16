<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'creator_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->optional()->dateTimeBetween('+1 month', '+2 months'),
            'location' => $this->faker->optional()->city(),
            'max_participants' => $this->faker->numberBetween(8, 64),
            'status' => $this->faker->randomElement(['open', 'closed', 'in progress', 'completed']),
        ];
    }
}
