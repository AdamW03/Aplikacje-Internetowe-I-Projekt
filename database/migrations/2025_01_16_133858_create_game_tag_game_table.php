<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_tag_game', function (Blueprint $table) {
            $table->foreignId('game_tag_id')->constrained('game_tags')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_tag_game');
    }
};
