<?php

namespace App\Repositories\Contracts;

use App\Models\Game;

interface GameRepositoryInterface
{
    public function create(Game $game): Game;
}
