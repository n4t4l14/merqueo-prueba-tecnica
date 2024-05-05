<?php

namespace App\Providers;

use App\Repositories\Contracts\{PlayersRepositoryInterface, TeamBatchesRepositoryInterface, TeamsRepositoryInterface};
use App\Repositories\{PlayersRepositoryEloquent, TeamBatchesRepositoryEloquent, TeamsRepositoryEloquent};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TeamsRepositoryInterface::class => TeamsRepositoryEloquent::class,
        PlayersRepositoryInterface::class => PlayersRepositoryEloquent::class,
        TeamBatchesRepositoryInterface::class => TeamBatchesRepositoryEloquent::class,
    ];
}
