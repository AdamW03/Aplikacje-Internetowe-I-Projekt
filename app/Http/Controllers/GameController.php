<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $games = Game::paginate($perPage);
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image_path' => 'nullable|string',
            'game_tags' => 'nullable|array',
            'game_tags.*' => 'exists:game_tags,id',
        ]);

        $game = Game::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image_path' => $validatedData['image_path'] ?? null,
        ]);

        if (isset($validatedData['game_tags'])) {
            $game->game_tags()->sync($validatedData['game_tags']);
        }

        return redirect()->route('games.index')->with('success', 'Game created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::with(['game_tags'])->findOrFail($id);

        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image_path' => 'nullable|string',
            'game_tags' => 'nullable|array',
            'game_tags.*' => 'exists:game_tags,id',
        ]);

        $game = Game::findOrFail($id);
        $game->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'image_path' => $validatedData['image_path'] ?? null,
        ]);

        if (isset($validatedData['game_tags'])) {
            $game->gameTags()->sync($validatedData['game_tags']);
        }

        return redirect()->route('games.index')->with('success', 'Game updated successfully!');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('game.index');
    }
}
