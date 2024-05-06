<?php

namespace App\Http\Controllers\Api\V1;

use App\Console\Commands\{CreateChampionshipCommand, RunChampionshipCommand};
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class ChampionshipsController extends Controller
{
    public function generateChampionship(): JsonResponse
    {
        Artisan::call(CreateChampionshipCommand::class);
        Artisan::call(RunChampionshipCommand::class);

        return response()->json(['message' => 'Championships generated successfully.']);
    }
}
