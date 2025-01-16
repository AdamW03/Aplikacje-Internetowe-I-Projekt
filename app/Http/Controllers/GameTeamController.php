<?php

namespace App\Http\Controllers;

use App\Models\GameTeam;
use Illuminate\Http\Request;

class GameTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $gameTeams = GameTeam::paginate($perPage);
        return view('game_teams.index', compact('gameTeams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('game_teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tournament_game_id' => 'required|exists:tournament_games,id',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $gameTeam = GameTeam::create([
            'tournament_game_id' => $validatedData['tournament_game_id'],
        ]);

        if (isset($validatedData['users'])) {
            $gameTeam->users()->sync($validatedData['users']);
        }

        return redirect()->route('game_teams.index')->with('success', 'Game team created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gameTeam = GameTeam::with(['users'])->findOrFail($id);
        return view('game_teams.show', compact('gameTeam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameTeam $gameTeam)
    {
        return view('game_teams.edit', compact('gameTeam'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tournament_game_id' => 'required|exists:tournament_games,id',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $gameTeam = GameTeam::findOrFail($id);

        $gameTeam->update([
            'tournament_game_id' => $validatedData['tournament_game_id'],
        ]);

        if (isset($validatedData['users'])) {
            $gameTeam->users()->sync($validatedData['users']);
        }

        return redirect()->route('game_teams.index')->with('success', 'Game team updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameTeam $gameTeam)
    {
        $gameTeam->delete();
        return redirect()->route('game_teams.index');
    }
}
