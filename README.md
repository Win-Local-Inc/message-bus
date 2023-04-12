# Message Bus Package

- All honor go to [joblocal/laravel-sqs-sns-subscription-queue](https://github.com/joblocal/laravel-sqs-sns-subscription-queue)

### Installation

- PHP 8.2 is required

- remove `sqs-sns` from `config/queue.php`, it will be added by provider, or update it with 

```php
'sqs-sns' => [
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
    ],
```

- add envs :

```env
AWS_SQS_HANDLER_PATHS= app paths to handlers separeted by "," resolved by App::path($path)
AWS_SQS_VALIDATOR_PATHS= app paths to validators separeted by "," resolved by App::path($path)
AWS_SQS_ACCESS_KEY_ID=
AWS_SQS_SECRET_ACCESS_KEY=
AWS_SQS_REGION=us-east-2
AWS_SQS_QUEUE=
AWS_SNS_TOPIC=
```
- handlers:

`There are two ways to implement handlers`
1. Standard `Laravel Job` 
    see -> [WinLocal\MessageBus\Tests\Data\Handlers\AdvertCreated.php](https://github.com/Win-Local-Inc/message-bus/blob/main/tests/Data/Handlers/AdvertCreated.php)
2. Interface `WinLocal\MessageBus\Contracts\ExecutorInterface` 
    see -> [WinLocal\MessageBus\Tests\Data\Handlers\AudienceCreated.php](https://github.com/Win-Local-Inc/message-bus/blob/main/tests/Data/Handlers/AudienceCreated.php)

Attribute [WinLocal\MessageBus\Attributes\HandleSubjects](https://github.com/Win-Local-Inc/message-bus/blob/main/src/Attributes/HandleSubjects.php) needs to be used, so resolver will use it.

- validators:

There is optional validator available, that will be excecuted before handlers.
Validator needs to extend [WinLocal\MessageBus\Contracts\AbstractExecutorValidator](https://github.com/Win-Local-Inc/message-bus/blob/main/src/Contracts/AbstractExecutorValidator.php)
    see -> [WinLocal\MessageBus\Tests\Data\Validators\AudienceCreated.php](https://github.com/Win-Local-Inc/message-bus/blob/main/tests/Data/Validators/AudienceCreated.php)

- push notification:

```php
WinLocal\MessageBus\Jobs\SnsSendJob::dispatch(\WinLocal\MessageBus\Enums\Subject $subject, array $message);
```

- each service needs to run supervisor

`php artisan queue:work sqs-sns --max-jobs=100 --tries=3 --max-time=3600`

- to run tests on package

`vendor/bin/testbench package:test --configuration=tests/phpunit.xml`