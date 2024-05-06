<?php

namespace Tests\Feature\Actions;

use App\Actions\Championships\CreateChampionshipAction;
use App\Models\{ChampionshipResult, Team};
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see CreateChampionshipAction
 */
class CreateChampionshipActionTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->action = $this->app->make(CreateChampionshipAction::class);
    }

    #[Test]
    public function itCanCreateChampionship(): void
    {
        $teams = Team::factory()->count(6)->create();
        $this->action->execute();

        $this->assertCount($teams->count(), ChampionshipResult::all());
        $query = Team::query()->join('games', function (JoinClause $join) {
            $join->on('teams.id', '=', 'games.team_id_a');
            $join->orWhere('teams.id', '=', DB::raw('games.team_id_b'));
        });

        $this->assertEquals($teams->count(), $query->count());
    }
}
