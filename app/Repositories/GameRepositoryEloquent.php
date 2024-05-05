<?php

namespace App\Repositories;

use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;

class GameRepositoryEloquent implements GameRepositoryInterface
{
    public function create(Game $game): Game
    {
        $game->save();

        return $game;
    }
}
