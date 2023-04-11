# Message Bus Package

- All honor go to [joblocal/laravel-sqs-sns-subscription-queue](https://github.com/joblocal/laravel-sqs-sns-subscription-queue)

### Installation

- add envs :

```env
AWS_SQS_HANDLER_PATHS= app path to handlers separeted by , resolved by App::path($path)
AWS_SQS_ACCESS_KEY_ID=
AWS_SQS_SECRET_ACCESS_KEY=
AWS_SQS_REGION=us-east-2
AWS_SQS_QUEUE=
AWS_SNS_TOPIC=
```

- push notification:

```php
WinLocal\MessageBus\Jobs\SnsSendJob::dispatch(string $subject, array $message);
```

- each service needs to run supervisor

`php artisan queue:work sqs-sns --max-jobs=100 --tries=3 --max-time=3600`