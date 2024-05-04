<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Teams\CreateAction;
use App\Exceptions\TeamsException;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Teams\StoreFormRequest;
use App\Http\Resources\V1\Teams\{TeamResource, TeamResourceCollection};
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index(Request $request, TeamsRepositoryInterface $repository): TeamResourceCollection
    {
        return TeamResourceCollection::make($repository->paginate($this->getPaginateData($request)));
    }

    public function show(int $id, TeamsRepositoryInterface $repository): TeamResource
    {
        return TeamResource::make($repository->show($id));
    }

    /**
     * @throws TeamsException
     */
    public function store(StoreFormRequest $request, CreateAction $action): TeamResource
    {
        return TeamResource::make($action->execute($request->validated('name'), $request->file('flag')));
    }
}
