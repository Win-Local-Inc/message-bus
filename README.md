# Message Bus Package

- add envs :

```env
WINLOCAL_MESSAGEBUS_PATH=aws-sns-webhook
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_REGION=
AWS_SNS_TOPIC=
```

- implement notification method:

```php
use WinLocal\MessageBus\Controllers\SnsController;

class SnsImlementation extends SnsController
{
    protected function notification(array $message)
    {
        // $message['MessageId']  store it to verify that this event was or not handled
        // $message['Subject'] we can use Subject as predefined Event names: User, Subscription ect...
        // $message['Message'] raw data, if json need to be decoded     
    }
}
```

- add controller to routes/api.php at root position

```php
Route::any(config('messagebus.path'), [SnsImlementation::class, 'handle']);
```

- push event:

```php
WinLocal\MessageBus\Jobs\MessageBusJob::dispatch(string $subject, array $message);
```
