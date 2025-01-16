<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TournamentGame;
use App\Models\Tournament;
use App\Models\GameTeam;
use App\Models\GameTag;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KolosEUSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gameTags = GameTag::factory(30)->create();
        $games = Game::factory(30)->create();

        $games->each(function ($game) use ($gameTags) {
            $randomTags = $gameTags->random(rand(2, 6));
            $game->game_tags()->sync($randomTags->pluck('id')->toArray());
        });

        Tournament::factory(50)->create()->each(function ($tournament) use ($games) {
            $selectedGame = $games->random();
            $tournament->game_id = $selectedGame->id;
            $tournament->save();

            $participantsCount = max(1, min($tournament->max_participants, $tournament->max_participants - rand(1, 2)));
            $participants = User::factory($participantsCount)->create();
            $tournament->participant_users()->sync($participants->pluck('id')->toArray());

            TournamentGame::factory(rand(4, 16))->create([
                'tournament_id' => $tournament->id,
            ])->each(function ($tournamentGame) {
                $gameTeams = GameTeam::factory(rand(1, 8))->create([
                    'tournament_game_id' => $tournamentGame->id,
                ])->each(function ($gameTeam) {
                    $users = User::inRandomOrder()->take(rand(1, 4))->get();
                    $gameTeam->users()->sync($users->pluck('id')->toArray());
                });
            });
        });

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
