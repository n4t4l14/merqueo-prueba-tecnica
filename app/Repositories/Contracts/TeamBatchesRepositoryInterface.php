<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TeamBatchesRepositoryInterface
{
    public function loadData(array $data);

    public function createTeams(): Collection;

    public function updateTeamProperties(int $teamNumber, string $message, int $teamId): void;

    public function createPlayers(): Collection;

    public function updatePlayersProperties(int $shirtNumber, int $teamId, string $message, int $playerId): void;
}
