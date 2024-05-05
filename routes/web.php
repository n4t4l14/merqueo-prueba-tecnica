<?php

use App\Http\Controllers\Web\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeamsController::class, 'index']);

Route::get('teams/{teamId}', [TeamsController::class, 'show'])->name('web.teams.show');
