<?php

namespace Database\Factories;

use App\Constants\TeamStatus;
use App\Models\ChampionshipResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChampionshipResult>
 */
class ChampionshipResultFactory extends Factory
{
    public function definition(): array
    {
        return [
            'championship_code' => time(),
            'current_round' => 1,
            'red_cards' => 0,
            'yellow_cards' => 0,
            'goals' => 0,
            'won_games' => 0,
            'lost_games' => 0,
            'team_status' => $this->faker->randomElement(TeamStatus::toArray()),
        ];
    }
}
