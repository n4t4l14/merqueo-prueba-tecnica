<?php

namespace App\Http\Resources\V1\Players;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayerResourceCollection extends ResourceCollection
{
    public $collects = PlayerResourceToPagination::class;
}
