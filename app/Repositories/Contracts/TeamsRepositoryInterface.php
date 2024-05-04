<?php

namespace App\Repositories\Contracts;

use App\DTO\PaginateData;
use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TeamsRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<Team>
     */
    public function paginate(PaginateData $paginateData): LengthAwarePaginator;

    public function show(int $id): Team;

    public function create(Team $data): Team;
}
