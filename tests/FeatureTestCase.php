<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected bool $shouldSeedTables = false;

    protected function setUp(): void
    {
        parent::setUp();
        if ($this->shouldSeedTables) {
            Artisan::call('db:seed');
        }
    }
}
