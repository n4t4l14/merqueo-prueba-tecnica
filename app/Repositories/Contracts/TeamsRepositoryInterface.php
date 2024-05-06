<?php

namespace App\Repositories\Contracts;

use App\DTO\PaginateData;
use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TeamsRepositoryInterface
{
    /**
     * @return LengthAwarePaginator<Team>
     */
    public function paginate(PaginateData $paginateData): LengthAwarePaginator;

    public function show(int $id): Team;

    /**
     * @return Collection<int, Team>
     */
    public function get(array $filters = []): Collection;

    /**
     * @return Collection<Team>
     */
    public function getTeamsToContinueNextRound(int $championshipCode): Collection;

    public function create(Team $data): Team;
}
