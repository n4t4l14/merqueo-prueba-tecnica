<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'championship_code' => time(),
            'round' => 1,
            'order' => 1,
            'team_id_b' => Team::factory(),
            'team_id_a' => Team::factory(),
            'red_card_a' => 2,
            'red_card_b' => 2,
            'yellow_card_a' => 3,
            'yellow_card_b' => 1,
            'goals_a' => 6,
            'goals_b' => 2,
            'winning_team_id' => 2,
            'losing_team_id' => 3,
        ];
    }
}