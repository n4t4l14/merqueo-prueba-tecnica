<?php

namespace App\Repositories;

use App\DTO\PaginateData;
use App\Models\Team;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TeamsRepositoryEloquent implements TeamsRepositoryInterface
{
    public function paginate(PaginateData $paginateData): LengthAwarePaginator
    {
        return Team::query()->paginate(
            perPage: $paginateData->perPage,
            page: $paginateData->page,
        );
    }

    public function show(int $id): Team
    {
        return Team::query()->findOrFail($id);
    }

    public function create(Team $data): Team
    {
        $data->save();

        return $data;
    }
}
