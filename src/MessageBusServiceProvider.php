<?php

namespace WinLocal\MessageBus;

use Illuminate\Support\ServiceProvider;
use WinLocal\MessageBus\Queue\Connectors\SqsSnsConnector;

class MessageBusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['queue']->extend('sqs-sns', function () {
            return new SqsSnsConnector;
        });
    }
}
