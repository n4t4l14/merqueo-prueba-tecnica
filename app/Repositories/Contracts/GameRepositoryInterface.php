<?php

namespace App\Repositories\Contracts;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

interface GameRepositoryInterface
{
    /**
     * @return Collection<int, Game>
     */
    public function getGamesToPlay(): Collection;

    public function create(Game $game): Game;

    public function update(Game $game): Game;
}
