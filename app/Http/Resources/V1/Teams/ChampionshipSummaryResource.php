<?php

namespace App\Http\Resources\V1\Teams;

use App\Models\ChampionshipResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ChampionshipResult $resource
 */
class ChampionshipSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'championship_code' => $this->resource->championship_code,
            'current_round' => $this->resource->current_round,
            'red_cards' => $this->resource->red_cards,
            'yellow_cards' => $this->resource->yellow_cards,
            'goals' => $this->resource->goals,
            'won_games' => $this->resource->won_games,
            'lost_games' => $this->resource->lost_games,
            'team_status' => $this->resource->team_status->getMessage(),
        ];
    }
}
