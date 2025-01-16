<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'draw',
        'winner_id',
    ];

    public function tournaments()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function game_teams()
    {
        return $this->hasMany(GameTeam::class);
    }
}
