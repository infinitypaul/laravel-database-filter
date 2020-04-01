<?php

namespace Infinitypaul\LaravelDatabaseFilter\Tests;

use Orchestra\Testbench\TestCase;
use Infinitypaul\LaravelDatabaseFilter\LaravelDatabaseFilterServiceProvider;

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
