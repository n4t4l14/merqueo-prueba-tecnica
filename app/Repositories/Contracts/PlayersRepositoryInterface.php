<?php

namespace App\Repositories\Contracts;

use App\DTO\PaginateData;
use App\Models\Player;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlayersRepositoryInterface
{
    public function paginate(PaginateData $paginateData): LengthAwarePaginator;

    public function show(int $id): Player;

    public function create(Player $data): Player;
}
