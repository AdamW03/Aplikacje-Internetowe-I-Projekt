<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'country',
        'description',
        'avatars',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function created_tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function tournament_games()
    {
        return $this->hasMany(TournamentGame::class);
    }

    public function participated_tournaments() {
        return $this->belongsToMany(Tournament::class, 'tournament_user');
    }

    public function game_teams()
    {
        return $this->belongsToMany(GameTeam::class, 'game_team_user');
    }

    public function getIsAdminAttribute()
    {
        return $this->id === 1;
    }
}
