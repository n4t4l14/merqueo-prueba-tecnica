<?php

namespace App\Providers;

use App\Repositories\Contracts\{GameRepositoryInterface,
    PlayersRepositoryInterface,
    TeamBatchesRepositoryInterface,
    TeamsRepositoryInterface};
use App\Repositories\{GameRepositoryEloquent,
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
    ];
}
