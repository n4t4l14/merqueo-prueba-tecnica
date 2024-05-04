<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Players\CreateAction;
use App\Exceptions\PlayersException;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Players\StoreFormRequest;
use App\Http\Resources\V1\Players\{PlayerResource, PlayerResourceCollection};
use App\Repositories\Contracts\PlayersRepositoryInterface;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function index(Request $request, PlayersRepositoryInterface $repository): PlayerResourceCollection
    {
        return PlayerResourceCollection::make($repository->paginate($this->getPaginateData($request)));
    }

    public function show(int $id, PlayersRepositoryInterface $repository): PlayerResource
    {
        return PlayerResource::make($repository->show($id));
    }

    /**
     * @throws PlayersException
     */
    public function store(StoreFormRequest $request, CreateAction $action): PlayerResource
    {
        return PlayerResource::make($action->execute($request->validated(), $request->file('photo')));
    }
}
