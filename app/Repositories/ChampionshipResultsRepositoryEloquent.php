<?php

namespace App\Repositories;

use App\Models\ChampionshipResult;
use App\Repositories\Contracts\ChampionshipResultsRepositoryInterface;

class ChampionshipResultsRepositoryEloquent implements ChampionshipResultsRepositoryInterface
{
    public function create(ChampionshipResult $championshipResult): ChampionshipResult
    {
        $championshipResult->save();

        return $championshipResult;
    }

    public function getMaxRound(int $championshipCode): int
    {
        $query = ChampionshipResult::query()
            ->selectRaw('MAX(current_round) as max_current_round')
            ->where('championship_code', $championshipCode)
            ->groupBy('championship_code');

        return $query->first()->getAttribute('max_current_round');
    }
}
