<?php

namespace App\Providers;

use App\Repositories\Contracts\{ChampionshipsRepositoryInterface,
    PlayersRepositoryInterface,
    TeamBatchesRepositoryInterface,
    TeamsRepositoryInterface};
use App\Repositories\{ChampionshipsRepositoryEloquent,
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
        ChampionshipsRepositoryInterface::class => ChampionshipsRepositoryEloquent::class,
    ];
}
