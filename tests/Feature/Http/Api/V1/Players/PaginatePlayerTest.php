<?php

namespace Tests\Feature\Http\Api\V1\Players;

use App\Http\Controllers\Api\V1\PlayersController;
use App\Models\{Player, Team};
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see PlayersController::index()
 */
class PaginatePlayerTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function itCanGetPlayers(): void
    {
        $team = Team::factory()->create();
        $players = Player::factory()->count(3)->create(['team_id' => $team->id]);

        /** @var Player $firstPlayer */
        $firstPlayer = $players->first();

        $this->getJson(route('api.v1.players.index', ['page' => 1, 'per_page' => 1]))
            ->assertJsonFragment([
                'id' => $firstPlayer->id,
                'name' => $firstPlayer->name,
                'nationality' => $firstPlayer->nationality,
                'age' => $firstPlayer->age,
                'position' => $firstPlayer->position,
                'shirt_number' => $firstPlayer->shirt_number,
                'photo' => $firstPlayer->photo,
                'team_id' => $firstPlayer->team_id,
                'total_red_card' => $firstPlayer->getAttribute('total_red_card'),
                'total_yellow_card' => $firstPlayer->getAttribute('total_yellow_card'),
            ])
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.total', 3)
        ->assertOk();
    }

    #[Test]
    public function itCanGetPlayersByTeam(): void
    {
        $players = collect();
        $teams = Team::factory()->count(2)->create()->each(function (Team $team) use (&$players) {
            Player::factory()->count(3)->create(['team_id' => $team->id])
                ->each(fn (Player $player) => $players->push($player));
        });

        /** @var Team $firstTeam */
        $firstTeam = $teams->first();

        /** @var Player $firstPlayer */
        $firstPlayer = $players->where('team_id', $firstTeam->id)->first();

        $this->getJson(route('api.v1.players.index', ['filters' => ['team_id' => $firstTeam->id]]))
            ->assertJsonFragment([
                [
                    'id' => $firstPlayer->id,
                    'name' => $firstPlayer->name,
                    'nationality' => $firstPlayer->nationality,
                    'age' => $firstPlayer->age,
                    'position' => $firstPlayer->position,
                    'shirt_number' => $firstPlayer->shirt_number,
                    'photo' => $firstPlayer->photo,
                    'team_id' => $firstPlayer->team_id,
                    'total_red_card' => $firstPlayer->getAttribute('total_red_card'),
                    'total_yellow_card' => $firstPlayer->getAttribute('total_yellow_card'),
                ],
            ])
            ->assertJsonPath('meta.total', 3)
            ->assertOk();
    }
}
