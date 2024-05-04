<?php

namespace App\Http\Resources\V1\Teams;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TeamResourceCollection extends ResourceCollection
{
    public $collects = TeamResourceToPagination::class;
}
