<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
    ];

    public function tournaments() {
        return $this->hasMany(Tournament::class);
    }

    public function game_tags()
    {
        return $this->belongsToMany(GameTag::class, 'game_tag_game');
    }
}
