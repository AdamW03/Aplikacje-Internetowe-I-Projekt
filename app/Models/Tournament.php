<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'creator_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'max_participants',
        'status',
    ];

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function creator_users()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function tournament_games()
    {
        return $this->hasMany(TournamentGame::class);
    }


    public function participant_users() {
        return $this->belongsToMany(User::class, 'tournament_user');
    }
}
