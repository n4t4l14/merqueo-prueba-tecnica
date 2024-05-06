<?php

namespace App\Repositories;

use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GameRepositoryEloquent implements GameRepositoryInterface
{
    public function getGamesToPlay(): Collection
    {
        return Game::query()
            ->whereNull('winning_team_id')
            ->whereNull('losing_team_id')
            ->orderBy('round')
            ->get();
    }

    public function create(Game $game): Game
    {
        $game->save();

        return $game;
    }

    public function update(Game $game): Game
    {
        $game->update();

        return $game;
    }
}
