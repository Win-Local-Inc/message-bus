<?php

namespace WinLocal\MessageBus\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        $messageClient->publish($this->subject, $this->message);
    }
}
