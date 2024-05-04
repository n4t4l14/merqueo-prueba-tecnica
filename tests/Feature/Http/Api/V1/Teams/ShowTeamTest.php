<?php

namespace Tests\Feature\Http\Api\V1\Teams;

use App\Http\Controllers\Api\V1\TeamsController;
use App\Models\Team;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see TeamsController::show()
 */
class ShowTeamTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function itCanGetTeam(): void
    {
        $team = Team::factory()->create();
        $this->getJson(route('api.v1.teams.show', $team))
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $team->id,
                    'name' => $team->name,
                    'flag' => $team->flag,
                ],
            ]);
    }

    #[Test]
    public function itThrowExceptionIfTeamDoesntExist(): void
    {
        $this->getJson(route('api.v1.teams.show', 1991))
            ->assertJsonFragment(['message' => 'No query results for model [App\Models\Team] 1991'])
            ->assertNotFound();
    }
}
