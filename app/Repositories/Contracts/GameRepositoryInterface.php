<?php

namespace App\Repositories\Contracts;

use App\DTO\PaginateData;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface GameRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<Game>
     */
    public function paginate(PaginateData $paginateData): LengthAwarePaginator;

    /**
     * @return Collection<int, Game>
     */
    public function getGamesToPlay(): Collection;

    public function create(Game $game): Game;

    public function update(Game $game): Game;
}
