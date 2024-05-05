<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Teams\TeamResource;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\View\View;

class TeamsController extends Controller
{
    public function index(): View
    {
        return view('pages.teams-index');
    }

    public function show(int $teamId, TeamsRepositoryInterface $repository): View
    {
        $team = TeamResource::make($repository->show($teamId))->toArray(request());

        return view('pages.teams-show', [
            'team' => $team,
            'teamName' => $team['name'],
        ]);
    }
}
