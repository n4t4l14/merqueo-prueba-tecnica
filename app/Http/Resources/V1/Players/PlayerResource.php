<?php

namespace App\Http\Resources\V1\Players;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Player $resource
 */
class PlayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'nationality' => $this->resource->nationality,
            'age' => $this->resource->age,
            'position' => $this->resource->position,
            'shirt_number' => $this->resource->shirt_number,
            'photo' => $this->resource->photo,
            'team_id' => $this->resource->team_id,
        ];
    }
}
