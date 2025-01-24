<?php

namespace App\Http\Controllers;
use App\Models\GameTag;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Game::with('game_tags');

        if ($request->has('game_name') && $request->game_name) {
            $query->where('name', 'like', '%' . $request->game_name . '%');
        }

        if ($request->has('game_tag') && $request->game_tag) {
            $query->whereHas('game_tags', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->game_tag . '%');
            });
        }


        $games = $query->paginate(20);
        $gameTags = GameTag::all();
        return view('games.index', compact('games','gameTags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gameTags = GameTag::all();
        return view('games.create', compact('gameTags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'game_tags' => 'nullable|array',
            'game_tags.*' => 'exists:game_tags,id',
        ]);

        $game = Game::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('games', 'public');
            $fileName = basename($imagePath);
            $validatedData['image_path'] = $fileName;
        }
        $game->fill($validatedData);

        if (isset($validatedData['game_tags'])) {
            $game->game_tags()->sync($validatedData['game_tags']);
        }

        $game->save();

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
        $gameTags = GameTag::all();
        return view('games.edit', compact('game', 'gameTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'game_tags' => 'nullable|array',
            'game_tags.*' => 'exists:game_tags,id'
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('games','public');
            $fileName = basename($imagePath);
            $validatedData['image_path'] = $fileName;
        }

        $game->fill($validatedData);
        $game->save();

        $game->game_tags()->sync($validatedData['game_tags']);

        return redirect()->route('games.index')->with('success', 'Gra została zaktualizowana.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully!');
    }
}
