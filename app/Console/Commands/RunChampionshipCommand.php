<?php

namespace App\Console\Commands;

use App\Actions\Championships\{GenerateGamesAction, RunChampionshipAction};
use App\Models\Game;
use App\Repositories\Contracts\{ChampionshipResultsRepositoryInterface, GameRepositoryInterface};
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class RunChampionshipCommand extends Command
{
    protected $signature = 'app:run-championship-command';

    protected $description = 'Command description';

    public function __construct(
        private readonly ChampionshipResultsRepositoryInterface $championshipResultsRepo,
        private readonly GameRepositoryInterface $gameRepository,
        private readonly RunChampionshipAction $action,
        private readonly GenerateGamesAction $generateGamesAction
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        // Primera ronda
        $this->warn('Inicia campeonato');
        $games = $this->gameRepository->getGamesToPlay()->each(fn (Game $game) => $this->playingGame($game));

        $championshipCode = $games->first()->championship_code;

        do {
            $games = $this->generateGamesAction
                ->execute($championshipCode, false)
                ->each(fn (Game $game) => $this->playingGame($game));

            $run = $games->isNotEmpty();
        } while ($run);

        $winningTeam = $this->championshipResultsRepo->defineChampionshipWinner($championshipCode);
        $this->info('Ganador del campeonato: ' . $winningTeam->team->name);

        return SymfonyCommand::SUCCESS;
    }

    private function playingGame(Game $game): void
    {
        $this->warn('Jugando partido (' . $game->order . ') de la ronda (' . $game->round . ')');
        $this->action->execute($game);
    }
}
