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
}
