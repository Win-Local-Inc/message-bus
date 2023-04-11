<?php

namespace WinLocal\MessageBus\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use WinLocal\MessageBus\Contracts\MessageClientInterface;

class SnsSendJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected string $subject, protected array $message)
    {
    }

    public function handle(MessageClientInterface $messageClient)
    {
        try {
            $messageClient->publish($this->subject, $this->message);
        } catch (Exception $exception) {
            Log::error('SnsSendJob '.$exception->getMessage(), [
                'exception' => $exception,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);
        }
    }
}
