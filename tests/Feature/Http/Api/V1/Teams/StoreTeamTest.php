<?php

namespace Tests\Feature\Http\Api\V1\Teams;

use App\Http\Controllers\Api\V1\TeamsController;
use App\Models\Team;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\{DataProvider, Test};
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\FeatureTestCase;

/**
 * @see TeamsController::store()
 */
class StoreTeamTest extends FeatureTestCase
{
    use WithFaker;

    private string $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url = route('api.v1.teams.store');
    }

    #[Test]
    public function itCanCreateTeam(): void
    {
        Storage::fake('public');
        $flag = UploadedFile::fake()->image('country.png');
        $body = ['name' => 'team' . time(), 'flag' => $flag];
        $response = $this->post($this->url, $body, ['Accept' => 'application/Json'])->assertCreated();

        /** @var Team $teamSaved */
        $teamSaved = Team::query()->firstWhere('name', $body['name']);

        $this->assertNotNull($teamSaved);
        $response->assertJson([
            'data' => [
                'id' => $teamSaved->id,
                'name' => $body['name'],
                'flag' => url("storage/countries/{$body['name']}.png"),
            ],
        ]);

        $this->assertDatabaseHas('teams', ['name' => $body['name']]);
    }

    #[Test]
    #[DataProvider('dataProviderTest400MalformedBody')]
    public function itReturns400OnMalFormedBody(array $replaceBody, array $responseExpected): void
    {
        $flag = UploadedFile::fake()->image('country.png');
        if ('Team Exists' == ($replaceBody['name'] ?? '')) {
            Team::query()->create($replaceBody);
            $replaceBody['flag'] = $flag;
        }

        $body = array_replace(['name' => 'team ' . time(), 'flag' => $flag], $replaceBody);

        $this->post($this->url, $body, ['Accept' => 'application/Json'])
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
                    'flag' => null,
                ],
                'responseExpected' => [
                    'message' => 'The name field is required. (and 1 more error)',
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'flag' => ['The flag field is required.'],
                    ],
                ],
            ],
            'it returns status (400) if request has properties with value is less than 4' => [
                'replaceBody' => [
                    'name' => 'tea',
                ],
                'responseExpected' => [
                    'message' => 'The name field must be at least 4 characters.',
                    'errors' => [
                        'name' => ['The name field must be at least 4 characters.'],
                    ],
                ],
            ],
            'it returns status (400) if request has properties exceeded' => [
                'replaceBody' => [
                    'name' => $faker->realTextBetween(),
                ],
                'responseExpected' => [
                    'message' => 'The name field must not be greater than 100 characters.',
                    'errors' => [
                        'name' => ['The name field must not be greater than 100 characters.'],
                    ],
                ],
            ],
            'it returns status (400) if request has file is different to image' => [
                'replaceBody' => [
                    'flag' => 'text',
                ],
                'responseExpected' => [
                    'message' => 'The flag field must be an image. (and 1 more error)',
                    'errors' => [
                        'flag' => [
                            'The flag field must be an image.',
                            'The flag field must be a file of type: jpeg, png, jpg, gif, svg.',
                        ],
                    ],
                ],
            ],
            'it returns status (400) if team already exists in system' => [
                'replaceBody' => [
                    'name' => 'Team Exists',
                    'flag' => 'https://flag.com',
                ],
                'responseExpected' => [
                    'message' => 'The name has already been taken.',
                    'errors' => [
                        'name' => [
                            'The name has already been taken.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
