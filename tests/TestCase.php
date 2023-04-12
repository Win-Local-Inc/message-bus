<?php

namespace WinLocal\MessageBus\Tests;

use WinLocal\MessageBus\MessageBusServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $loadEnvironmentVariables = false;

    protected function getPackageProviders($app)
    {
        return [MessageBusServiceProvider::class];
    }
}
