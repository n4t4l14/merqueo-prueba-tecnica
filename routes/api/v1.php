<?php

use App\Http\Controllers\Api\V1\TeamsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/teams')->name('teams.')->group(function () {
    Route::apiResource('', TeamsController::class)->parameter('', 'teams')->only('index', 'store', 'show');
});
