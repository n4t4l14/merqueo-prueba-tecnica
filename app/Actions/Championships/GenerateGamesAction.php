<?php

namespace App\Actions\Championships;

use App\Exceptions\ChampionshipException;
use App\Models\Game;
use App\Repositories\Contracts\{GameRepositoryInterface, TeamsRepositoryInterface};
use Illuminate\Support\Collection;

class GenerateGamesAction
{
    public function __construct(
        private readonly TeamsRepositoryInterface $teamsRepository,
        private readonly GameRepositoryInterface $gameRepository
    ) {
    }

    /**
     * @throws ChampionshipException
     */
    public function execute(int $championshipCode, ?bool $startChampionship = true): Collection
    {
        if ($startChampionship) {
            $teams = $this->teamsRepository->get();
            if (0 !== $teams->count() % 2) {
                throw new ChampionshipException('La cantidad de equipos debe ser par para iniciar el campeonato!');
            }

            return $this->createGames(teams: $teams, championshipCode: $championshipCode, round: 1);
        }

        // TODO: Lógica para generar siguiente ronda
        return collect();
    }

    private function createGames(Collection $teams, int $championshipCode, int $round): Collection
    {
        $teamsNewOrder = $teams->shuffle();
        $teamsGroups = $teamsNewOrder->chunk(2);

        $order = 1;
        $games = collect();
        $teamsGroups->each(function (Collection $teams) use ($championshipCode, &$order, &$games, $round) {
            $game = new Game([
                'championship_code' => $championshipCode,
                'round' => $round,
                'order' => $order,
                'team_id_a' => $teams->first()->id,
                'team_id_b' => $teams->last()->id,
            ]);

            $games->push($this->gameRepository->create($game));
            ++$order;
        });

        return $games;
    }
}
