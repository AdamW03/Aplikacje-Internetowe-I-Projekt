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
Route::resource('games', GameController::class);
Route::resource('game_teams', GameTeamController::class);
Route::resource('game_tags', GameTagController::class);
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
