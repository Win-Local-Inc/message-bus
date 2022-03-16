# Message Bus Package

- All honor go to [joblocal/laravel-sqs-sns-subscription-queue](https://github.com/joblocal/laravel-sqs-sns-subscription-queue)

### Installation

- update providers array in `config/app.php` with 

```php
WinLocal\MessageBus\MessageBusServiceProvider::class,
```

- update connections array in `config/queue.php` with 

```php
'sqs-sns' => [
    'driver' => 'sqs-sns',
    'key'    => env('AWS_SQS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SQS_SECRET_ACCESS_KEY'),
    'queue'  => env('AWS_SQS_QUEUE', 'your-queue-url'),
    'region' => env('AWS_SQS_REGION', 'us-east-2'),
    'topic' => env('AWS_SNS_TOPIC'),
    'routes' => [
        env('AWS_SNS_TOPIC') => 'App\\Jobs\\SqsGetJob',
    ],
    'version' => 'latest',
    'ua_append' => [
        'L5MOD/' . Aws\Laravel\AwsServiceProvider::VERSION,
    ],
    ],
```

- add envs :

```env
AWS_SQS_ACCESS_KEY_ID=
AWS_SQS_SECRET_ACCESS_KEY=
AWS_SQS_REGION=us-east-2
AWS_SQS_QUEUE=
AWS_SNS_TOPIC=
```

- implement notification entry point, namespace name and class name must match `config/queue.php`, default `App\\Jobs\\SqsGetJob`:

```php
namespace App\Jobs;

class SqsGetJob extends \WinLocal\MessageBus\Jobs\SqsGetJob
{
    public function handle()
    {
        print_r([
            'subject' => $this->subject, // string
            'payload' => $this->payload // array
        ]);
    }
}
```

- push notification:

```php
WinLocal\MessageBus\Jobs\SnsSendJob::dispatch(string $subject, array $message);
```

- each service needs to run supervisor

`php artisan queue:work sqs-sns --max-jobs=100 --tries=3 --max-time=3600`