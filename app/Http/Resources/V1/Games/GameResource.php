<?php

namespace App\Http\Resources\V1\Games;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Game $resource
 */
class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'championship_code' => $this->resource->championship_code,
            'round' => $this->resource->round,
            'order' => $this->resource->order,
            'team_id_a' => $this->resource->team_id_a,
            'team_id_b' => $this->resource->team_id_b,
            'red_card_a' => $this->resource->red_card_a,
            'red_card_b' => $this->resource->red_card_b,
            'yellow_card_a' => $this->resource->yellow_card_a,
            'yellow_card_b' => $this->resource->yellow_card_b,
            'goals_a' => $this->resource->goals_a,
            'goals_b' => $this->resource->goals_b,
            'winning_team_id' => $this->resource->winning_team_id,
            'losing_team_id' => $this->resource->losing_team_id,
            'team_name_a' => $this->resource->getAttribute('team_name_a'),
            'team_name_b' => $this->resource->getAttribute('team_name_b'),
            'winning_team_name' => $this->resource->getAttribute('winning_team_name'),
            'losing_team_name' => $this->resource->getAttribute('losing_team_name'),
        ];
    }
}