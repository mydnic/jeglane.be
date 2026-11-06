<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Every page renders app.blade.php, which reads public/build/manifest.json
        // and throws when it is missing. The suite is not what checks the assets
        // are buildable, the build job is, so it runs without them.
        $this->withoutVite();
    }
}
