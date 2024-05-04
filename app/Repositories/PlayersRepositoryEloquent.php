<?php

namespace App\Repositories;

use App\DTO\PaginateData;
use App\Models\Player;
use App\Repositories\Contracts\PlayersRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PlayersRepositoryEloquent implements PlayersRepositoryInterface
{
    public function paginate(PaginateData $paginateData): LengthAwarePaginator
    {
        return Player::query()->paginate(
            perPage: $paginateData->perPage,
            page: $paginateData->page,
        );
    }

    public function show(int $id): Player
    {
        return Player::query()->findOrFail($id);
    }

    public function create(Player $data): Player
    {
        $data->save();

        return $data;
    }
}
