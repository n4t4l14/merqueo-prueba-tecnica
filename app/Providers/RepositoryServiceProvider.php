<?php

namespace App\Providers;

use App\Repositories\Contracts\{ChampionshipResultsRepositoryInterface,
    GameRepositoryInterface,
    PlayersRepositoryInterface,
    TeamBatchesRepositoryInterface,
    TeamsRepositoryInterface};
use App\Repositories\{ChampionshipResultsRepositoryEloquent,
    GameRepositoryEloquent,
    PlayersRepositoryEloquent,
    TeamBatchesRepositoryEloquent,
    TeamsRepositoryEloquent};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TeamsRepositoryInterface::class => TeamsRepositoryEloquent::class,
        PlayersRepositoryInterface::class => PlayersRepositoryEloquent::class,
        TeamBatchesRepositoryInterface::class => TeamBatchesRepositoryEloquent::class,
        GameRepositoryInterface::class => GameRepositoryEloquent::class,
        ChampionshipResultsRepositoryInterface::class => ChampionshipResultsRepositoryEloquent::class,
    ];
}
