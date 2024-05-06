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
        $team = $repository->show($teamId);
        $championResult = $team->championshipResult;
        $team = TeamResource::make($team)->toArray(request());

        return view('pages.teams-show', [
            'team' => $team,
            'teamName' => $team['name'],
            'championship' => $championResult,
            'championshipResult' => $team['championship_summary']->toArray(request()),
        ]);
    }
}
