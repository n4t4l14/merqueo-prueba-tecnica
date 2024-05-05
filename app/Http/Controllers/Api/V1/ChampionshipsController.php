<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Championships\CreateChampionshipAction;
use App\Http\Controllers\Api\Controller;

class ChampionshipsController extends Controller
{
    public function store(CreateChampionshipAction $action)
    {
        return $action->execute();
    }
}