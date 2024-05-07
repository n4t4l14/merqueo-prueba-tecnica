<?php

namespace Tests\Feature\Http\Api\V1\Games;

use App\Http\Controllers\Api\V1\GamesController;
use App\Models\Game;
use App\Models\Team;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see GamesController
 */
class PaginateGameTest extends FeatureTestCase
{
    #[Test]
    public function itCanGetGames(): void
    {
        $teams = Team::factory()->count(4)->create();
        $games = Game::factory()->count(3)->create([
            'team_id_a' => $teams[0]->id,
            'team_id_b' => $teams[1]->id,
            'winning_team_id' => $teams[0]->id,
            'losing_team_id' => $teams[1]->id,
        ]);

        /** @var Game $firstGame */
        $firstGame = $games->first();

        $this->getJson(route('api.v1.games.index', ['page' => 1, 'per_page' => 1]))
            ->assertJsonFragment([
                'id' => $firstGame->id,
                'championship_code' => $firstGame->championship_code,
                'round' => $firstGame->round,
                'order' => $firstGame->order,
                'team_id_a' => $firstGame->team_id_a,
                'team_id_b' => $firstGame->team_id_b,
                'red_card_a' => $firstGame->red_card_a,
                'red_card_b' => $firstGame->red_card_b,
                'yellow_card_a' => $firstGame->yellow_card_a,
                'yellow_card_b' => $firstGame->yellow_card_b,
                'goals_a' => $firstGame->goals_a,
                'goals_b' => $firstGame->goals_b,
                'winning_team_id' => $firstGame->winning_team_id,
            ])
            ->assertOk();
    }
}