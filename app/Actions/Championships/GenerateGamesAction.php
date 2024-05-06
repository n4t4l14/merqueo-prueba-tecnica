<?php

namespace App\Actions\Championships;

use App\Exceptions\ChampionshipException;
use App\Models\{Game, Team};
use App\Repositories\Contracts\{ChampionshipResultsRepositoryInterface,
    GameRepositoryInterface,
    TeamsRepositoryInterface};
use Illuminate\Database\Eloquent\Collection;

class GenerateGamesAction
{
    public function __construct(
        private readonly ChampionshipResultsRepositoryInterface $championshipResultRepository,
        private readonly TeamsRepositoryInterface $teamsRepository,
        private readonly GameRepositoryInterface $gameRepository,
    ) {
    }

    /**
     * @throws ChampionshipException
     */
    public function execute(int $championshipCode, ?bool $startChampionship = true): Collection
    {
        if ($startChampionship) {
            $round = 1;
            $teams = $this->teamsRepository->get();
            if (0 !== $teams->count() % 2) {
                throw new ChampionshipException('La cantidad de equipos debe ser par para iniciar el campeonato!');
            }
        } else {
            $teams = $this->teamsRepository->getTeamsToContinueNextRound($championshipCode);
            $round = $this->championshipResultRepository->getMaxRound($championshipCode) + 1;
        }

        return $this->createGames(teams: $teams, championshipCode: $championshipCode, round: $round);
    }

    private function createGames(Collection $teams, int $championshipCode, int $round): Collection
    {
        $teamsNewOrder = $teams->shuffle();
        $teamsGroups = $teamsNewOrder->chunk(2);

        $order = 1;
        $games = Collection::make();
        $teamsGroups->each(function (Collection $teams) use ($championshipCode, &$order, &$games, $round) {
            /** @var Team $teamA */
            $teamA = $teams->first();

            /** @var Team $teamB */
            $teamB = $teams->last();

            if ($teamA->id == $teamB->id) {
                return;
            }

            $game = new Game([
                'championship_code' => $championshipCode,
                'round' => $round,
                'order' => $order,
                'team_id_a' => $teamA->id,
                'team_id_b' => $teamB->id,
            ]);

            $games->push($this->gameRepository->create($game));
            ++$order;
        });

        return $games;
    }
}
