<?php

namespace App\Repositories\Contracts;

use App\Models\ChampionshipResult;
use Illuminate\Support\Collection;

interface ChampionshipResultsRepositoryInterface
{
    public function getMaxRound(int $championshipCode): int;

    /**
     * @return Collection<ChampionshipResult>
     */
    public function getByTeamId(array $teamsId): Collection;

    public function create(ChampionshipResult $championshipResult): ChampionshipResult;

    public function update(ChampionshipResult $championshipResult): ChampionshipResult;

    public function defineChampionshipWinner(int $championshipCode): ChampionshipResult;
}
