<?php

namespace App\Http\Controllers;

use App\Models\GameTag;
use Illuminate\Http\Request;

class GameTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $gameTags = GameTag::paginate($perPage);
        return view('game_tags.index', compact('gameTags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('game_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        GameTag::create($validated);

        return redirect()->route('game_tags.index')->with('success', 'Game Tag created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GameTag $gameTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameTag $gameTag)
    {
        return view('game_tags.edit', compact('gameTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GameTag $gameTag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $gameTag->update($validated);

        return redirect()->route('game_tags.index')->with('success', 'Game Tag updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameTag $gameTag)
    {
        $gameTag->delete();
        return redirect()->route('game_tags.index')->with('success', 'Game Tag deleted successfully!');
    }
}
