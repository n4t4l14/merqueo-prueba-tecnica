<?php

namespace App\Actions\Championships;

use App\Models\{ChampionshipResult, Team};
use App\Repositories\Contracts\{ChampionshipResultsRepositoryInterface, TeamsRepositoryInterface};

class CreateChampionshipAction
{
    public function __construct(
        private readonly TeamsRepositoryInterface $teamsRepository,
        private readonly ChampionshipResultsRepositoryInterface $championshipResultsRepository,
        private readonly GenerateGamesAction $generateGamesAction,
    ) {
    }

    public function execute(): void
    {
        $championshipCode = time();
        $this->teamsRepository->get()->each(function (Team $team) use ($championshipCode) {
            $championship = new ChampionshipResult([
                'championship_code' => $championshipCode,
                'current_round' => 1,
                'team_id' => $team->id,
            ]);

            $this->championshipResultsRepository->create($championship);
        });

        $this->generateGamesAction->execute($championshipCode);
    }
}
