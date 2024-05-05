<?php

namespace App\Actions;

use App\Models\{Player, Team};
use App\Repositories\Contracts\{PlayersRepositoryInterface, TeamBatchesRepositoryInterface, TeamsRepositoryInterface};
use League\Csv\Reader;

class BulkLoadAction
{
    public function __construct(
        private readonly TeamBatchesRepositoryInterface $batchesRepository,
        private readonly TeamsRepositoryInterface $teamsRepository,
        private readonly PlayersRepositoryInterface $playersRepository
    ) {
    }

    public function execute(string $pathFile): bool
    {
        $this->loadData($pathFile);
        $this->createTeams();
        $this->CreatePlayers();

        return true;
    }

    private function loadData(string $pathFile): void
    {
        $csv = Reader::createFromPath($pathFile)->setHeaderOffset(0);

        $data = [];
        foreach ($csv as $row) {
            $data[] = [
                'team_number' => $row['team_number'],
                'team_name' => $row['team_name'],
                'team_flag' => $row['team_flag'],
                'player_name' => $row['player_name'],
                'player_nationality' => $row['player_nationality'],
                'player_age' => $row['player_age'],
                'player_position' => $row['player_position'],
                'player_shirt_number' => $row['player_shirt_number'],
                'player_photo' => $row['player_photo'],
            ];
        }

        $this->batchesRepository->loadData($data);
    }

    private function createTeams(): void
    {
        $teamsToCreated = $this->batchesRepository->createTeams();

        $teamsToCreated->each(function (\stdClass $team) {
            if ($team->team_exists) {
                $this->batchesRepository->updateTeamProperties($team->team_number, 'Equipo Existente', $team->team_id);

                return;
            }

            $flag = current(explode(',', $team->team_flag));
            $flagUrl = filter_var($flag, FILTER_VALIDATE_URL) ? $flag : url('storage/countries/general_flag.png');
            $teamCreated = $this->teamsRepository->create(new Team(['name' => $team->team_name, 'flag' => $flagUrl]));

            $this->batchesRepository->updateTeamProperties($team->team_number, 'Equipo creado', $teamCreated->id);
        });
    }

    private function CreatePlayers(): void
    {
        $playersToCreated = $this->batchesRepository->createPlayers();

        $playersToCreated->each(function (\stdClass $player) {
            if ($player->player_exists) {
                $this->batchesRepository->updatePlayersProperties(
                    $player->player_shirt_number,
                    $player->team_id,
                    'Jugador Existente',
                    $player->player_id
                );

                return;
            }

            $photo = current(explode(',', $player->player_photo));
            $photoUrl = filter_var($photo, FILTER_VALIDATE_URL) ? $photo : url('storage/players/general_photo.jpg');

            $newPlayer = new Player([
                'name' => $player->player_name,
                'nationality' => $player->player_nationality,
                'age' => $player->player_age,
                'position' => $player->player_position,
                'shirt_number' => $player->player_shirt_number,
                'photo' => $photoUrl,
                'team_id' => $player->team_id,
            ]);

            $playerCreated = $this->playersRepository->create($newPlayer);

            $this->batchesRepository->updatePlayersProperties(
                $newPlayer->shirt_number,
                $newPlayer->team_id,
                'Jugador Creado',
                $playerCreated->id
            );
        });
    }
}
