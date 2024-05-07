<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\V1\Games\GameResourceCollection;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index(Request $request, GameRepositoryInterface $gameRepository): GameResourceCollection
    {
        return GameResourceCollection::make($gameRepository->paginate($this->getPaginateData($request)));
    }
}