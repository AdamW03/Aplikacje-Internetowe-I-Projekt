<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TournamentGame;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameTeam>
 */
class GameTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_game_id' => TournamentGame::factory(),
        ];
    }
}
