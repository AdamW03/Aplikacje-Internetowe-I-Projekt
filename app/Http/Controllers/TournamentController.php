<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Game;
use App\Models\GameTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tournament::with(['games.game_tags', 'creator_users', 'participant_users']);

        if ($request->has('tournament_name') && $request->tournament_name) {
            $query->where('name', 'like', '%' . $request->tournament_name . '%');
        }

        if ($request->has('game_name') && $request->game_name) {
            $query->whereHas('games', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->game_name . '%');
            });
        }

        if ($request->has('game_tag') && $request->game_tag) {
            $query->whereHas('games.game_tags', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->game_tag . '%');
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tournaments = $query->paginate(10);

        $games = Game::all();
        $gameTags = GameTag::all();

        return view('tournaments.index', compact('tournaments', 'games', 'gameTags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::all();
        return view('tournaments.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|exists:games,id',
//            'creator_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'per_team' => 'required|integer|in:' . implode(',', $this->getDivisors($request->max_participants)),
//            'status' => 'required|in:scheduled,ongoing,finished,open'
        ]);

        $tournament = Tournament::create([
            'game_id' => $validatedData['game_id'],
            'creator_id' => Auth::id(),
//            'creator_id' => $validatedData['creator_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'] ?? null,
            'location' => $validatedData['location'] ?? null,
            'max_participants' => $validatedData['max_participants'],
            'per_team' => $validatedData['per_team'],
            'status' => 'open',
        ]);

        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::with(['games', 'creator_users', 'tournament_games', 'tournament_games.users', 'participant_users'])->findOrFail($id);

        return view('tournaments.show', compact('tournament', ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        $games = Game::all();
        return view('tournaments.edit', compact('tournament', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|exists:games,id',
            'creator_id' => 'required|exists:users,id',
//            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'per_team' => 'required|integer|in:' . implode(',', $this->getDivisors($request->max_participants)),
            'status' => 'required|in:scheduled,ongoing,finished,open',
//            'teams' => 'nullable|array',
//            'teams.*' => 'exists:teams,id',
        ]);

        $tournament = Tournament::findOrFail($id);
        $tournament->update([
            'game_id' => $validatedData['game_id'],
//            'creator_id' => Auth::id(),
//            'creator_id' => $validatedData['creator_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'] ?? null,
            'location' => $validatedData['location'] ?? null,
            'max_participants' => $validatedData['max_participants'],
            'per_team' => $validatedData['per_team'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('tournaments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index');
    }

    private function getDivisors($number)
    {
        $divisors = [];
        for ($i = 1; $i <= $number; $i++) {
            if ($number % $i === 0) {
                $divisors[] = $i;
            }
        }
        return $divisors;
    }

    public function join($tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);

        // Check if the user is already registered
        if ($tournament->participant_users()->where('user_id', auth()->user()->id)->exists()) {
            return redirect()->route('tournaments.show', $tournamentId)->with('error', 'You are already registered.');
        }

        // Register the user
        $tournament->participant_users()->attach(auth()->user()->id);

        // Check if the tournament is full and change the status to 'scheduled'
        if ($tournament->participant_users()->count() >= $tournament->max_participants) {
            $tournament->status = 'scheduled';
            $tournament->save();
        }

        return redirect()->route('tournaments.show', $tournamentId)->with('success', 'You have successfully joined the tournament.');
    }

    public function leave($tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);

        // Check if the user is registered
        $registration = $tournament->participant_users()->where('user_id', auth()->user()->id)->first();

        if (!$registration) {
            return redirect()->route('tournaments.show', $tournamentId)->with('error', 'You are not registered in this tournament.');
        }

        // Remove the user from the tournament
        $tournament->participant_users()->detach(auth()->user()->id);

        // If there are still fewer than the max participants, status should be 'open'
        if ($tournament->participant_users()->count() < $tournament->max_participants) {
            $tournament->status = 'open';
            $tournament->save();
        }

        return redirect()->route('tournaments.show', $tournamentId)->with('success', 'You have successfully left the tournament.');
    }

}
