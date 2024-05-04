<?php

namespace App\Http\Resources\V1\Teams;

use Illuminate\Http\Request;

class TeamResourceToPagination extends TeamResource
{
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'total_red_card' => $this->resource->getAttribute('total_red_card'),
            'total_yellow_card' => $this->resource->getAttribute('total_yellow_card'),
            'total_goals' => $this->resource->getAttribute('total_goals'),
            'match_won' => $this->resource->getAttribute('match_won'),
            'match_lost' => $this->resource->getAttribute('match_lost'),
        ];
    }
}
