<?php

namespace App\Actions\Championships;

use App\Models\Championship;
use App\Models\Team;
use App\Repositories\Contracts\ChampionshipsRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;

class CreateChampionshipAction
{
    public function __construct(
        private readonly TeamsRepositoryInterface $teamsRepository,
        private readonly ChampionshipsRepositoryInterface $championshipsRepository
    ) {
    }

    public function execute()
    {
        $teamsCount = Team::count();
        dd($teamsCount);
        $championship = new Championship();


        dd($championship);
    }
}