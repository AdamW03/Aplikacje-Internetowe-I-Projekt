<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameTeamController;
use App\Http\Controllers\GameTagController;
use App\Http\Controllers\TournamentGameController;
use App\Http\Controllers\AdminUserController;

Route::resource('tournaments', TournamentController::class);
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournaments.show');

// Dostęp tylko dla zalogowanych użytkowników
Route::middleware('auth')->group(function () {
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::get('/tournaments/{id}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::put('/tournaments/{id}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    // Akcje dołączenia i opuszczenia turnieju
    Route::post('/tournaments/{id}/join', [TournamentController::class, 'join'])->name('tournaments.join');
    Route::post('/tournaments/{id}/leave', [TournamentController::class, 'leave'])->name('tournaments.leave');
});

Route::resource('games', GameController::class);
// Trasy dostępne dla każdego użytkownika (gościa i zalogowanego)
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');

// Trasy dostępne tylko dla zalogowanych użytkowników
Route::middleware('auth')->group(function () {
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
});
Route::middleware(['admin'])->group(function () {
    Route::get('/game_tags/create', [GameTagController::class, 'create'])->name('game_tags.create');
    Route::get('/game_tags/{gameTag}/edit', [GameTagController::class, 'edit'])->name('game_tags.edit');
});

Route::resource('game_tags', GameTagController::class);
// Trasy dostępne dla każdego użytkownika (gościa i zalogowanego)
Route::get('/game_tags', [GameTagController::class, 'index'])->name('game_tags.index');
Route::middleware('auth')->group(function () {
    Route::post('/game_tags', [GameTagController::class, 'store'])->name('game_tags.store');
});
// Trasy tylko dla administratorów
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/game_tags/create', [GameTagController::class, 'create'])->name('game_tags.create');
    Route::get('/game_tags/{gameTag}/edit', [GameTagController::class, 'edit'])->name('game_tags.edit');
});

Route::resource('game_teams', GameTeamController::class);

Route::resource('tournament_games', TournamentGameController::class);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('tournaments/{tournament}/join', [TournamentController::class, 'join'])->name('tournaments.join');
Route::delete('tournaments/{tournament}/leave', [TournamentController::class, 'leave'])->name('tournaments.leave');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [AdminUserController::class, 'unban'])->name('admin.users.unban');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
