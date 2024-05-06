<?php

namespace App\Repositories;

use App\Constants\TeamStatus;
use App\DTO\PaginateData;
use App\Models\Team;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TeamsRepositoryEloquent implements TeamsRepositoryInterface
{
    public function paginate(PaginateData $paginateData): LengthAwarePaginator
    {
        $query = Team::query();

        $query = $query
            ->select([
                'teams.id',
                'teams.name',
                'teams.flag',
                'teams.created_at',
                'championship_results.red_cards as total_red_card',
                'championship_results.yellow_cards as total_yellow_card',
                'championship_results.goals as total_goals',
                'championship_results.won_games as match_won',
                'championship_results.lost_games as match_lost',
            ])
            ->leftJoin('championship_results', 'teams.id', '=', 'championship_results.team_id');

        logger($query->toRawSql());

        return $query->paginate(
            perPage: $paginateData->perPage,
            page: $paginateData->page,
        );
    }

    public function show(int $id): Team
    {
        return Team::query()->findOrFail($id);
    }

    public function get(array $filters = []): Collection
    {
        return empty($filters) ? Team::query()->get() : Team::query()->where($filters)->get();
    }

    public function getTeamsToContinueNextRound(int $championshipCode): Collection
    {
        $query = Team::query();

        $query
            ->select(['teams.*'])
            ->join('championship_results', 'teams.id', '=', 'championship_results.team_id')
            ->where('championship_results.championship_code', $championshipCode)
            ->where('team_status', TeamStatus::CONTINUE);

        return $query->get();
    }

    public function create(Team $data): Team
    {
        $data->save();

        return $data;
    }
}
