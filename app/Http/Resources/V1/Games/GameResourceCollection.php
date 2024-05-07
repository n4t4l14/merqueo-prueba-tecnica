<?php

namespace App\Http\Resources\V1\Games;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GameResourceCollection extends ResourceCollection
{
    public $collects = GameResourceToPagination::class;
}