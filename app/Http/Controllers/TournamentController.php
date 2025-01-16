<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $tournaments = Tournament::paginate($perPage);
        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|exists:games,id',
            'creator_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'per_team' => 'required|integer|in:' . implode(',', $this->getDivisors($request->max_participants)),
            'status' => 'required|in:scheduled,ongoing,finished,open'
        ]);

        $tournament = Tournament::create([
            'game_id' => $validatedData['game_id'],
            'creator_id' => $validatedData['creator_id'],
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::with(['games', 'users', 'tournament_games', 'tournament_user'])->findOrFail($id);

        return view('tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|exists:games,id',
            'creator_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'per_team' => 'required|integer|in:' . implode(',', $this->getDivisors($request->max_participants)),
            'status' => 'required|in:scheduled,ongoing,finished',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
        ]);

        $tournament = Tournament::findOrFail($id);
        $tournament->update([
            'game_id' => $validatedData['game_id'],
            'creator_id' => $validatedData['creator_id'],
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
}
