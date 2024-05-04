<?php

namespace App\Providers;

use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Repositories\TeamsRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        TeamsRepositoryInterface::class => TeamsRepositoryEloquent::class,
    ];
}
