<?php

namespace App\Http\Controllers;

use App\Models\TournamentGame;
use Illuminate\Http\Request;

class TournamentGameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $tournamentGame = TournamentGame::paginate($perPage);
        return view('tournament_games.index', compact('tournamentGame'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tournament_games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        TournamentGame::create([
            'tournament_id' => $validated['tournament_id'],
        ]);

        return redirect()->route('tournament_games.index')->with('success', 'Tournament Game created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TournamentGame $tournamentGame)
    {
        $tournament_games = TournamentGame::with(['users', 'tournaments', 'game_teams'])->findOrFail($id);
        return view('tournament_games.show', compact('tournament_games'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TournamentGame $tournamentGame)
    {
        return view('tournament_games.edit', compact('tournamentGame'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'draw' => 'nullable|boolean',
            'winner_id' => 'nullable|exists:users,id',
        ]);

        $tournamentGame = TournamentGame::findOrFail($id);

        $tournamentGame->update([
            'tournament_id' => $validatedData['tournament_id'],
            'draw' => $validatedData['draw'] ?? $tournamentGame->draw,
            'winner_id' => $validatedData['winner_id'] ?? $tournamentGame->winner_id,
        ]);

        return redirect()->route('tournament_games.index')->with('success', 'Tournament Game updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TournamentGame $tournamentGame)
    {
        $tournamentGame->delete();
        return redirect()->route('tournament_games.index');
    }
}
