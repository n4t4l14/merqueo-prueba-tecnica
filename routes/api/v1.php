<?php

use App\Http\Controllers\Api\V1\{PlayersController, TeamsController};
use Illuminate\Support\Facades\Route;

Route::prefix('/teams')->name('teams.')->group(function () {
    Route::apiResource('', TeamsController::class)->parameter('', 'teams')->only('index', 'store', 'show');
});

Route::prefix('/players')->name('players.')->group(function () {
    Route::apiResource('', PlayersController::class)->parameter('', 'players')->only('index', 'store', 'show');
});
