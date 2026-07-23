<?php

namespace Infinitypaul\LaravelDatabaseFilter\Tests;

use Infinitypaul\LaravelDatabaseFilter\LaravelDatabaseFilterServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelDatabaseFilterServiceProvider::class];
    }

    #[Test]
    public function true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
