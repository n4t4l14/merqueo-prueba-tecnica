<?php

namespace App\Repositories;

use App\Constants\TeamStatus;
use App\DTO\PaginateData;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GameRepositoryEloquent implements GameRepositoryInterface
{
    public function paginate(PaginateData $paginateData): LengthAwarePaginator
    {
        $query = Game::query();
        $query->select([
            'games.*',
            'teams.name as team_name_a',
            'teams2.name as team_name_b',
            'teams3.name as winning_team_name',
            'teams4.name as losing_team_name',
        ])
        ->leftJoin('teams', 'games.team_id_a', '=', 'teams.id')
        ->leftJoin('teams as teams2', 'games.team_id_b', '=', 'teams2.id')
        ->leftJoin('teams as teams3', 'games.winning_team_id', '=', 'teams3.id')
        ->leftJoin('teams as teams4', 'games.losing_team_id', '=', 'teams4.id');

        logger($query->toRawSql());
        return $query->paginate(perPage: $paginateData->perPage, page: $paginateData->page);
    }

    public function getGamesToPlay(): Collection
    {
        return Game::query()
            ->whereNull('winning_team_id')
            ->whereNull('losing_team_id')
            ->orderBy('round')
            ->get();
    }

    public function create(Game $game): Game
    {
        $game->save();

        return $game;
    }

    public function update(Game $game): Game
    {
        $game->update();

        return $game;
    }
}
