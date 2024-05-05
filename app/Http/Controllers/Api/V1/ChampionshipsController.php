<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Championships\GenerateGamesAction;
use App\Http\Controllers\Api\Controller;

class ChampionshipsController extends Controller
{
    public function store(GenerateGamesAction $action)
    {
        return $action->execute(time());
    }
}
