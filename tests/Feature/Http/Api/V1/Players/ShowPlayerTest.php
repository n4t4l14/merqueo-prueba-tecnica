<?php

namespace Tests\Feature\Http\Api\V1\Players;

use App\Http\Controllers\Api\V1\PlayersController;
use App\Models\{Player, Team};
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see PlayersController::show()
 */
class ShowPlayerTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function itCanGetPlayer(): void
    {
        $team = Team::factory()->create();
        $player = Player::factory()->create(['team_id' => $team->id]);
        $this->getJson(route('api.v1.players.show', $player->id))
        ->assertOk()
        ->assertJson([
            'data' => [
                'id' => $player->id,
                'name' => $player->name,
                'nationality' => $player->nationality,
                'age' => $player->age,
                'position' => $player->position,
                'shirt_number' => $player->shirt_number,
                'photo' => $player->photo,
                'team_id' => $player->team_id,
            ],
        ]);
    }

    #[Test]
    public function itThrowExceptionIfPlayerDoesntExists(): void
    {
        $this->getJson(route('api.v1.players.show', 1991))
            ->assertJsonFragment(['message' => 'No query results for model [App\Models\Player] 1991'])
            ->assertNotFound();
    }
}
