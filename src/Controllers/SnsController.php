<?php

namespace WinLocal\MessageBus\Controllers;

use Exception;
use Aws\Sns\Message;
use Aws\Sns\MessageValidator;
use Illuminate\Support\Facades\Log;
use Nette\NotImplementedException;

class SnsController extends Controller
{
    public function handle()
    {
        try {
            $message = Message::fromRawPostData();
            $validator = new MessageValidator();
            if ($validator->isValid($message)) {
                if ($message['Type'] == 'SubscriptionConfirmation') {
                    file_get_contents($message['SubscribeURL']);
                } elseif ($message['Type'] == 'UnsubscribeConfirmation') {
                    file_get_contents($message['UnsubscribeURL']);
                } elseif ($message['Type'] == 'Notification') {
                    $this->notification($message->toArray());
                }
            } else {
                Log::warning('Sns Message Is Invalid', ['message' => $message->toArray()]);
            }
        } catch (Exception $e) {
            Log::error('Sns Message Exception', ['exception' => $e]);
        }

        return response('OK');
    }

    protected function notification(array $message)
    {
        // $message['MessageId'] =  store it to verify that this event was or not handled
        // $message['Subject'] we can use Subject as predefined Event names: User, Subscription ect...
        // $message['Message'] === raw data, if json need to be decoded
        throw new NotImplementedException('SnsController notification is not implemented');
    }
}
