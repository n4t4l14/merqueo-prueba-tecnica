<?php

namespace Tests\Feature\Http\Api\V1\Teams;

use App\Http\Controllers\Api\V1\TeamsController;
use App\Models\Team;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see TeamsController::index()
 */
class PaginateTeamTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function itCanGetTeam(): void
    {
        $teams = Team::factory()->count(5)->create();

        /** @var Team $firstTeam */
        $firstTeam = $teams->first();

        $this->getJson(route('api.v1.teams.index', ['page' => 1, 'per_page' => 1]))
            ->assertJsonFragment([
                'id' => $firstTeam->id,
                'name' => $firstTeam->name,
                'flag' => $firstTeam->flag,
                'total_red_card' => $firstTeam->getAttribute('total_red_card'),
                'total_yellow_card' => $firstTeam->getAttribute('total_yellow_card'),
                'total_goals' => $firstTeam->getAttribute('total_goals'),
                'match_won' => $firstTeam->getAttribute('match_won'),
                'match_lost' => $firstTeam->getAttribute('match_lost'),
            ])
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.total', 5)
            ->assertOk();
    }
}
