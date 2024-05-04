<?php

namespace Tests\Feature\Http\Api\V1\Players;

use App\Http\Controllers\Api\V1\PlayersController;
use App\Models\{Player, Team};
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\{DataProvider, Test};
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\FeatureTestCase;

/**
 * @see PlayersController::store()
 */
class StorePlayerTest extends FeatureTestCase
{
    use WithFaker;

    private string $url;
    private Team $team;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url = route('api.v1.players.store');
        $this->team = Team::factory()->create();
    }

    #[Test]
    public function itCanCreatePlayer(): void
    {
        Storage::fake('public');
        $photo = UploadedFile::fake()->image('player.png');
        $body = [
            'name' => 'David Ospina',
            'nationality' => 'Colombiano',
            'age' => 23,
            'position' => 'Arquero',
            'shirt_number' => 1,
            'photo' => $photo,
            'team_id' => $this->team->id,
        ];
        $response = $this->postJson($this->url, $body, ['Accept' => 'application/json'])
            ->assertCreated();

        /** @var Player $playerSaved */
        $playerSaved = Player::query()->firstWhere('name', $body['name']);

        $this->assertNotNull($playerSaved);
        $response->assertJson([
            'data' => [
                'id' => $playerSaved->id,
                'name' => $body['name'],
                'nationality' => $body['nationality'],
                'age' => $body['age'],
                'position' => $body['position'],
                'shirt_number' => $body['shirt_number'],
                'photo' => $playerSaved->photo,
                'team_id' => $body['team_id'],
            ],
        ]);

        $this->assertDatabaseHas('players', [
            'name' => $body['name'],
            'nationality' => $body['nationality'],
            'age' => $body['age'],
            'position' => $body['position'],
            'shirt_number' => $body['shirt_number'],
            'photo' => $playerSaved->photo,
            'team_id' => $body['team_id'],
        ]);
    }

    #[Test]
    #[DataProvider('dataProviderTest400MalformedBody')]
    public function itReturns400OnMalFormedBodyPlayer(array $replaceBody, array $responseExpected): void
    {
        $photo = UploadedFile::fake()->image('player.png');
        if ('Player Exists' == ($replaceBody['name'] ?? null)) {
            $replaceBody['photo'] = $photo;
            $player = Player::factory()->create([
                'team_id' => $this->team->id,
            ]);
            $replaceBody['name'] = $player->name;
            $replaceBody['shirt_number'] = $player->shirt_number;
        }

        $body = array_replace([
            'name' => 'David Ospina',
            'nationality' => 'Colombiano',
            'age' => 23,
            'position' => 'Arquero',
            'shirt_number' => 1,
            'photo' => $photo,
            'team_id' => $this->team->id,
        ], $replaceBody);

        $this->post($this->url, $body, ['Accept' => 'application/json'])
            ->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson($responseExpected);
    }

    public static function dataProviderTest400MalformedBody(): array
    {
        $faker = Factory::create();

        return [
            'it returns status (400) if request has null data' => [
                'replaceBody' => [
                    'name' => null,
                    'nationality' => null,
                    'age' => null,
                    'position' => null,
                    'shirt_number' => null,
                    'photo' => null,
                    'team_id' => null,
                ],
                'responseExpected' => [
                    'message' => 'The name field is required. (and 6 more errors)',
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'nationality' => ['The nationality field is required.'],
                        'age' => ['The age field is required.'],
                        'position' => ['The position field is required.'],
                        'shirt_number' => ['The shirt number field is required.'],
                        'photo' => ['The photo field is required.'],
                        'team_id' => ['The team id field is required.'],
                    ],
                ],
            ],
            'it returns status (400) if request has properties exceeded' => [
                'replaceBody' => [
                    'name' => $faker->realTextBetween(),
                    'nationality' => $faker->realTextBetween(),
                    'position' => $faker->realTextBetween(),
                ],
                'responseExpected' => [
                    'message' => 'The name field must not be greater than 100 characters. (and 2 more errors)',
                    'errors' => [
                        'name' => ['The name field must not be greater than 100 characters.'],
                        'nationality' => ['The nationality field must not be greater than 20 characters.'],
                        'position' => ['The position field must not be greater than 30 characters.'],
                    ],
                ],
            ],
            'it returns status (400) if request has file is different to image' => [
                'replaceBody' => [
                    'photo' => 'text',
                ],
                'responseExpected' => [
                    'message' => 'The photo field must be a file. (and 2 more errors)',
                    'errors' => [
                        'photo' => [
                            'The photo field must be a file.',
                            'The photo field must be an image.',
                            'The photo field must be a file of type: jpeg, png, jpg.',
                        ],
                    ],
                ],
            ],
            'it returns status (400) if request has properties is different to int' => [
                'replaceBody' => [
                    'age' => 'text',
                    'shirt_number' => 'text',
                    'team_id' => 'text',
                ],
                'responseExpected' => [
                    'message' => 'The age field must be an integer. (and 2 more errors)',
                    'errors' => [
                        'age' => ['The age field must be an integer.'],
                        'shirt_number' => ['The shirt number field must be an integer.'],
                        'team_id' => ['The team id field must be an integer.'],
                    ],
                ],
            ],
            'it returns status (400) if shirt number already exist in team' => [
                'replaceBody' => [
                    'name' => 'Player Exists',
                ],
                'responseExpected' => [
                    'message' => 'The shirt number is already registered for this team.',
                    'errors' => [
                        'team_id' => [
                            'The shirt number is already registered for this team.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
