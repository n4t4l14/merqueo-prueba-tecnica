<?php

namespace App\Repositories;

use App\Repositories\Contracts\TeamBatchesRepositoryInterface;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TeamBatchesRepositoryEloquent implements TeamBatchesRepositoryInterface
{
    public function loadData(array $data): void
    {
        DB::statement('truncate team_batches;');
        DB::table('team_batches')->insert($data);
    }

    public function createTeams(): Collection
    {
        return DB::table('team_batches')
            ->select([
                DB::raw('team_batches.team_name'),
                DB::raw('GROUP_CONCAT(distinct team_batches.team_number) as team_number'),
                DB::raw('GROUP_CONCAT(distinct teams.id) as team_id'),
                DB::raw('GROUP_CONCAT(distinct team_batches.team_flag) as team_flag'),
                DB::raw('GROUP_CONCAT(distinct if(teams.id is null, false, true)) as team_exists'),
            ])
            ->leftJoin('teams', 'teams.name', '=', 'team_batches.team_name')
            ->groupBy('team_batches.team_name')
            ->get();
    }

    public function updateTeamProperties(int $teamNumber, string $message, int $teamId): void
    {
        DB::table('team_batches')
            ->where('team_number', $teamNumber)
            ->update(['team_status' => $message, 'team_id' => $teamId]);
    }

    public function createPlayers(): Collection
    {
        return DB::table('team_batches')
            ->select(['team_batches.*',
                DB::raw('if(players.id is null, false, true) as player_exists'),
            ])
            ->leftJoin('players', function (JoinClause $join) {
                $join->on('players.shirt_number', '=', 'team_batches.player_shirt_number');
                $join->whereRaw('players.team_id = team_batches.team_id');
            })
            ->get();
    }

    public function updatePlayersProperties(int $shirtNumber, int $teamId, string $message, ?int $playerId): void
    {
        DB::table('team_batches')
            ->where('player_shirt_number', $shirtNumber)
            ->where('team_id', $teamId)
            ->update(['player_status' => $message, 'player_id' => $playerId]);
    }
}
