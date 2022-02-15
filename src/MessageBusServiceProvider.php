<?php

namespace WinLocal\MessageBus;

use Illuminate\Support\ServiceProvider;

class MessageBusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configure();
    }

    protected function configure()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/messagebus.php', 'messagebus');
        $configPath = $this->app->basePath().'/config/messagebus.php';

        $this->publishes([
            __DIR__.'/../config/messagebus.php' => $configPath,
        ], 'config');
    }
}
