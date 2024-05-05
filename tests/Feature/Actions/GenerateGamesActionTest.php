<?php

namespace Tests\Feature\Actions;

use App\Actions\Championships\GenerateGamesAction;
use App\Exceptions\ChampionshipException;
use App\Models\{Game, Team};
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see GenerateGamesAction
 */
class GenerateGamesActionTest extends FeatureTestCase
{
    private GenerateGamesAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = $this->app->make(GenerateGamesAction::class);
    }

    #[Test]
    public function itCanStartChampionship(): void
    {
        $teams = Team::factory()->count(6)->create();
        $this->action->execute();

        $this->assertCount(3, Game::all());

        $query = Team::query()->join('games', function (JoinClause $join) {
            $join->on('teams.id', '=', 'games.team_id_a');
            $join->orWhere('teams.id', '=', DB::raw('games.team_id_b'));
        });

        $this->assertEquals($teams->count(), $query->count());
    }

    #[Test]
    public function itCanGenerateNextChampionshipRound(): void
    {
        Team::factory()->count(6)->create();
        $games = $this->action->execute();
    }

    #[Test]
    public function itThrowsExceptionIfTeamQuantityIsInvalid(): void
    {
        Team::factory()->count(5)->create();

        $this->expectException(ChampionshipException::class);
        $this->expectExceptionMessage('La cantidad de equipos debe ser par para iniciar el campeonato!');
        $this->action->execute();
    }

    public function beginDatabaseTransaction()
    {
    }
}
