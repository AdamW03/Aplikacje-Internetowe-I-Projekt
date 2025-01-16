<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tournament;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TournamentGame>
 */
class TournamentGameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => Tournament::factory(),
            'draw' => $this->faker->boolean(10),
            'winner_id' => $this->faker->optional(0.9)->randomElement(User::pluck('id')->toArray()),
        ];
    }
}
