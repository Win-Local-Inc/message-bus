<?php

namespace WinLocal\MessageBus\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use WinLocal\MessageBus\Contracts\MessageClientInterface;
use WinLocal\MessageBus\Enums\Subject;

class SnsSendJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Subject $subject, protected array $message)
    {
    }

    public function handle(MessageClientInterface $messageClient)
    {
        try {
            $messageClient->publish($this->subject, $this->message);
        } catch (Exception $exception) {
            Log::error('SnsSendJob '.$exception->getMessage(), [
                'exception' => $exception,
                'subject' => $this->subject->value,
                'message' => $this->message,
            ]);
        }
    }
}
