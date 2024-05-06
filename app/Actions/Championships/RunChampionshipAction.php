<?php

namespace App\Actions\Championships;

use App\Constants\TeamStatus;
use App\Models\{ChampionshipResult, Game};
use App\Repositories\Contracts\{ChampionshipResultsRepositoryInterface, GameRepositoryInterface};

class RunChampionshipAction
{
    private Game $game;
    private ChampionshipResult $teamASummary;
    private ChampionshipResult $teamBSummary;

    public function __construct(
        private readonly GameRepositoryInterface $gameRepository,
        private readonly ChampionshipResultsRepositoryInterface $championshipResultsRepo,
    ) {
    }

    public function execute(Game $game): void
    {
        $this->game = $game;
        $this->setGameProperties();
        $this->setTeamsSummary();

        if ($this->game->goals_a > $this->game->goals_b) {
            $this->winningTeamA();
        } elseif ($this->game->goals_b > $this->game->goals_a) {
            $this->winningTeamB();
        } elseif ($game->isFirstRound()) {
            // Empate primera ronda
            $this->execute($game);
        } else {
            $this->tiebreaker();
        }

        $this->teamASummary->current_round = $game->round;
        $this->teamBSummary->current_round = $game->round;

        $this->gameRepository->update($game);
        $this->championshipResultsRepo->update($this->teamASummary);
        $this->championshipResultsRepo->update($this->teamBSummary);
    }

    private function setGameProperties(): void
    {
        // Team A
        $this->game->red_card_a = rand(0, 7);
        $this->game->yellow_card_a = rand(0, 7);
        $this->game->goals_a = rand(0, 6);

        // Team B
        $this->game->red_card_b = rand(0, 7);
        $this->game->yellow_card_b = rand(0, 7);
        $this->game->goals_b = rand(0, 6);
    }

    private function setTeamsSummary(): void
    {
        $game = $this->game;
        $teamsSummary = $this->championshipResultsRepo->getByTeamId([$game->team_id_a, $game->team_id_b]);

        $this->teamASummary = $teamsSummary->where('team_id', $game->team_id_a)->first();
        $this->teamASummary->goals += $game->goals_a;
        $this->teamASummary->red_cards += $game->red_card_a;
        $this->teamASummary->yellow_cards += $game->yellow_card_a;

        $this->teamBSummary = $teamsSummary->where('team_id', $game->team_id_b)->first();
        $this->teamBSummary->goals += $game->goals_b;
        $this->teamBSummary->red_cards += $game->red_card_b;
        $this->teamBSummary->yellow_cards += $game->yellow_card_b;
    }

    private function tiebreaker(): void
    {
        // Gana quien tiene menos partidos perdidos
        if ($this->teamASummary->lost_games < $this->teamBSummary->lost_games) {
            $this->winningTeamA();
        } elseif ($this->teamASummary->lost_games > $this->teamBSummary->lost_games) {
            $this->winningTeamB();
        } else {
            // Gana quien tiene más goles acumulados
            if ($this->teamASummary->goals > $this->teamBSummary->goals) {
                $this->winningTeamA();
            } elseif ($this->teamASummary->goals < $this->teamBSummary->goals) {
                $this->winningTeamB();
            } else {
                // Gana quien tiene menos tarjetas rojas acumulados
                if ($this->teamASummary->red_cards < $this->teamBSummary->red_cards) {
                    $this->winningTeamA();
                } elseif ($this->teamASummary->red_cards > $this->teamBSummary->red_cards) {
                    $this->winningTeamB();
                } else {
                    // Gana quien tiene menos tarjetas amarillas acumulados
                    if ($this->teamASummary->yellow_cards < $this->teamBSummary->yellow_cards) {
                        $this->winningTeamA();
                    } elseif ($this->teamASummary->yellow_cards > $this->teamBSummary->yellow_cards) {
                        $this->winningTeamB();
                    } else {
                        $this->execute($this->game);
                    }
                }
            }
        }
    }

    private function winningTeamA(): void
    {
        $this->game->winning_team_id = $this->game->team_id_a;
        $this->game->losing_team_id = $this->game->team_id_b;

        $this->teamASummary->team_status = TeamStatus::CONTINUE;
        ++$this->teamASummary->won_games;

        $this->teamBSummary->team_status = TeamStatus::ELIMINATED;
        ++$this->teamBSummary->lost_games;
    }

    private function winningTeamB(): void
    {
        $this->game->winning_team_id = $this->game->team_id_b;
        $this->game->losing_team_id = $this->game->team_id_a;

        $this->teamBSummary->team_status = TeamStatus::CONTINUE;
        ++$this->teamBSummary->won_games;

        $this->teamASummary->team_status = TeamStatus::ELIMINATED;
        ++$this->teamASummary->lost_games;
    }
}
