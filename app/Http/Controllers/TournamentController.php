<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Game;
use App\Models\User;
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
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,ongoing,finished'
        ]);

        $tournament = Tournament::create([
            'game_id' => $validatedData['game_id'],
            'creator_id' => $validatedData['creator_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'] ?? null, //Dodane obsługa null
            'location' => $validatedData['location'] ?? null, //Dodane obsługa null
            'max_participants' => $validatedData['max_participants'],
            'status' => $validatedData['status'],
        ]);

        if (isset($validatedData['teams'])) {
            $tournament->teams()->sync($validatedData['teams']);
        }

        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = Tournament::with(['games', 'users', 'teams'])->findOrFail($id);

        // Przekazujemy obiekt Tournament oraz powiązane dane do widoku
        return view('tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
            'status' => $validatedData['status'],
        ]);

        if (isset($validatedData['teams'])) {
            $tournament->teams()->sync($validatedData['teams']);
        }

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
}
