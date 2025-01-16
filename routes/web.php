<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTeamController;
use App\Http\Controllers\GameTagController;
use App\Http\Controllers\TournamentGameController;

Route::resource('tournaments', TournamentController::class);
Route::resource('games', GameController::class);
Route::resource('game_teams', GameTeamController::class);
Route::resource('game_tags', GameTagController::class);
Route::resource('tournament_games', TournamentGameController::class);

Route::get('/', [TournamentController::class, 'index'])->name('home');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
