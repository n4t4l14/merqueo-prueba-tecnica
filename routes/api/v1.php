<?php

use App\Http\Controllers\Api\V1\{ChampionshipsController, PlayersController, TeamsController};
use Illuminate\Support\Facades\Route;

Route::prefix('/teams')->name('teams.')->group(function () {
    Route::apiResource('', TeamsController::class)->parameter('', 'teams')->only('index', 'store', 'show');
    Route::post('/bulk-load', [TeamsController::class, 'bulkLoad'])->name('bulk-load');
});

Route::prefix('/players')->name('players.')->group(function () {
    Route::apiResource('', PlayersController::class)->parameter('', 'players')->only('index', 'store', 'show');
});

Route::prefix('/championships')->name('championships.')->group(function () {
    Route::get('/', [ChampionshipsController::class, 'generateChampionship'])->name('generate-championship');
});
