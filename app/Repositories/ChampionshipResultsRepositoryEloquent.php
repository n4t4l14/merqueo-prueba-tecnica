<?php

namespace App\Repositories;

use App\Constants\TeamStatus;
use App\Models\ChampionshipResult;
use App\Repositories\Contracts\ChampionshipResultsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ChampionshipResultsRepositoryEloquent implements ChampionshipResultsRepositoryInterface
{
    public function getMaxRound(int $championshipCode): int
    {
        $query = ChampionshipResult::query()
            ->selectRaw('MAX(current_round) as max_current_round')
            ->where('championship_code', $championshipCode)
            ->groupBy('championship_code');

        return $query->first()->getAttribute('max_current_round');
    }

    public function getByTeamId(array $teamsId): Collection
    {
        $query = ChampionshipResult::query();
        $query->whereIn('team_id', $teamsId);

        return $query->get();
    }

    public function create(ChampionshipResult $championshipResult): ChampionshipResult
    {
        $championshipResult->save();

        return $championshipResult;
    }

    public function update(ChampionshipResult $championshipResult): ChampionshipResult
    {
        $championshipResult->update();

        return $championshipResult;
    }

    public function defineChampionshipWinner(int $championshipCode): ChampionshipResult
    {
        /** @var ChampionshipResult $winningTeam */
        $winningTeam = ChampionshipResult::query()
            ->where('championship_code', $championshipCode)
            ->where('team_status', TeamStatus::CONTINUE)
            ->firstOrFail();

        $winningTeam->team_status = TeamStatus::WINNER;
        $winningTeam->save();

        return $winningTeam;
    }
}
