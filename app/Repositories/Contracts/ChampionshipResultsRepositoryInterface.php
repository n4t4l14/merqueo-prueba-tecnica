<?php

namespace App\Repositories\Contracts;

use App\Models\ChampionshipResult;

interface ChampionshipResultsRepositoryInterface
{
    public function create(ChampionshipResult $championshipResult): ChampionshipResult;

    public function getMaxRound(int $championshipCode): int;
}
