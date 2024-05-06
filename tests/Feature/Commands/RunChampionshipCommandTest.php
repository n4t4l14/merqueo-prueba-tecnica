<?php

namespace Tests\Feature\Commands;

use App\Actions\Championships\CreateChampionshipAction;
use App\Console\Commands\RunChampionshipCommand;
use App\Models\Team;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

/**
 * @see RunChampionshipCommand
 */
class RunChampionshipCommandTest extends FeatureTestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bootChampionship();
    }

    #[Test]
    public function itCanRunEnableChampionship(): void
    {
        $this->artisan(RunChampionshipCommand::class)->assertSuccessful();
    }

    private function bootChampionship(): void
    {
        Team::factory()->create(['name' => 'Colombia', 'flag' => $this->faker()->imageUrl]);
        Team::factory()->create(['name' => 'Argentina', 'flag' => $this->faker()->imageUrl]);
        Team::factory()->create(['name' => 'Brasil', 'flag' => $this->faker()->imageUrl]);
        Team::factory()->create(['name' => 'Cuba', 'flag' => $this->faker()->imageUrl]);
        Team::factory()->create(['name' => 'Chile', 'flag' => $this->faker()->imageUrl]);
        Team::factory()->create(['name' => 'México', 'flag' => $this->faker()->imageUrl]);

        $this->app->make(CreateChampionshipAction::class)->execute();
    }
}
