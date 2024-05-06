<?php

namespace Tests\Feature\Actions;

use App\Actions\Championships\GenerateGamesAction;
use App\Constants\TeamStatus;
use App\Exceptions\ChampionshipException;
use App\Models\{ChampionshipResult, Game, Team};
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

    private int $championshipCode;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = $this->app->make(GenerateGamesAction::class);
        $this->championshipCode = time();
    }

    #[Test]
    public function itCanStartChampionship(): void
    {
        $teams = Team::factory()->count(6)->create();
        $this->action->execute($this->championshipCode);

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
        $teams = Team::factory()->count(6)->create();
        $teams->each(function (Team $team, int $key) {
            ChampionshipResult::factory([
                'team_id' => $team->id,
                'championship_code' => $this->championshipCode,
                'team_status' => (0 === $key % 2) ? TeamStatus::CONTINUE : TeamStatus::ELIMINATED,
                'current_round' => 1,
            ])->create();
        });

        // 1ra ronda
        $games = $this->action->execute($this->championshipCode);
        $this->assertCount(3, $games);

        // 2da ronda
        $games = $this->action->execute($this->championshipCode, false);
        $this->assertCount(1, $games);

        $game = $games->first();
        ChampionshipResult::query()->where('team_id', '=', $game->team_id_a)->update([
            'team_status' => TeamStatus::ELIMINATED,
            'current_round' => 2,
        ]);

        // 3ra ronda
        $games = $this->action->execute($this->championshipCode, false);
        $game = $games->first();
        ChampionshipResult::query()->where('team_id', '=', $game->team_id_a)->update([
            'team_status' => TeamStatus::ELIMINATED,
            'current_round' => 3,
        ]);

        $games = $this->action->execute($this->championshipCode, false);
        $this->assertTrue($games->isEmpty());
    }

    #[Test]
    public function itThrowsExceptionIfTeamQuantityIsInvalid(): void
    {
        Team::factory()->count(5)->create();

        $this->expectException(ChampionshipException::class);
        $this->expectExceptionMessage('La cantidad de equipos debe ser par para iniciar el campeonato!');
        $this->action->execute($this->championshipCode);
    }
}
