<?php

namespace WinLocal\MessageBus;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use WinLocal\MessageBus\Providers\MessageClient;
use WinLocal\MessageBus\Providers\HandlerResolver;
use WinLocal\MessageBus\Contracts\MessageClientInterface;
use WinLocal\MessageBus\Queue\Connectors\SqsSnsConnector;
use WinLocal\MessageBus\Contracts\HandlerResolverInterface;

class MessageBusServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configure();

        $this->app['queue']->extend('sqs-sns', function () {
            return new SqsSnsConnector();
        });

        $this->app->singleton(MessageClientInterface::class, function () {
            $config = config('queue.connections.sqs-sns');
            $config += [
                'credentials' => Arr::only($config, ['key', 'secret']),
            ];

            return new MessageClient($config);
        });

        $this->app->singleton(HandlerResolverInterface::class, function () {
            return new HandlerResolver();
        });
    }

    protected function configure()
    {
        config([
            'queue.connections.sqs-sns' => array_merge([
                'driver' => 'sqs-sns',
                'key' => env('AWS_SQS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SQS_SECRET_ACCESS_KEY'),
                'queue' => env('AWS_SQS_QUEUE', 'your-queue-url'),
                'region' => env('AWS_SQS_REGION', 'us-east-2'),
                'topic' => env('AWS_SNS_TOPIC'),
                'routes' => [
                    env('AWS_SNS_TOPIC') => 'WinLocal\\MessageBus\\Jobs\\SqsGetJob',
                ],
                'version' => 'latest',
                'ua_append' => [
                    'L5MOD/'.\Aws\Laravel\AwsServiceProvider::VERSION,
                ],
            ], config('queue.connections.sqs-sns', []))
        ]);

        $this->mergeConfigFrom(__DIR__.'/../config/messagebus.php', 'messagebus');
        $configPath = $this->app->basePath().'/config/messagebus.php';

        $this->publishes([
            __DIR__.'/../config/messagebus.php' => $configPath,
        ], 'config');
    }
}
