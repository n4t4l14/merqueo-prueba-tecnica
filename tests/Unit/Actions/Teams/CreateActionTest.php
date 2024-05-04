<?php

namespace Tests\Unit\Actions\Teams;

use App\Actions\Teams\CreateAction;
use App\Exceptions\TeamsException;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateActionTest extends TestCase
{
    private CreateAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = $this->app->make(CreateAction::class);
    }

    #[Test]
    public function itThrowExceptionIfSaveImageFails(): void
    {
        /** @var UploadedFile $flag */
        $flag = $this->mock(UploadedFile::class, function ($mock) {
            $mock->shouldReceive('extension')->once()->andReturn('png');
            $mock->shouldReceive('storeAs')->once()->andReturnFalse();
        });

        $this->expectException(TeamsException::class);
        $this->expectExceptionMessage('Error al subir el archivo');
        $this->action->execute('team Test', $flag);
    }
}
