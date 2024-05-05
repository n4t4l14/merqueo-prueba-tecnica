<?php

namespace App\Http\Resources\V1\Teams;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Team $resource
 */
class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'flag' => $this->resource->flag,
            'created_at' => $this->resource->created_at,
        ];
    }
}
