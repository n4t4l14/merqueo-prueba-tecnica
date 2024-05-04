<?php

namespace App\Providers;

use App\Repositories\Contracts\{PlayersRepositoryInterface, TeamsRepositoryInterface};
use App\Repositories\{PlayersRepositoryEloquent, TeamsRepositoryEloquent};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TeamsRepositoryInterface::class => TeamsRepositoryEloquent::class,
        PlayersRepositoryInterface::class => PlayersRepositoryEloquent::class,
    ];
}
