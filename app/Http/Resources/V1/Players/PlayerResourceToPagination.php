<?php

namespace App\Http\Resources\V1\Players;

use Illuminate\Http\Request;

class PlayerResourceToPagination extends PlayerResource
{
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'total_red_card' => $this->resource->getAttribute('total_red_card'),
            'total_yellow_card' => $this->resource->getAttribute('total_yellow_card'),
        ];
    }
}
