<?php

namespace Infinitypaul\LaravelDatabaseFilter\Tests;

use Infinitypaul\LaravelDatabaseFilter\LaravelDatabaseFilterServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelDatabaseFilterServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
