<?php

namespace WinLocal\MessageBus\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nette\NotImplementedException;

class SqsGetJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected string $subject;
    protected array $payload;

    /**
     * @param string  $subject   SNS Subject
     * @param array   $payload   JSON decoded 'Message'
     */
    public function __construct(string $subject, array $payload)
    {
        $this->subject  = $subject;
        $this->payload  = $payload;
    }

    public function handle()
    {
        Log::info('SqsGetJob', [
            'subject' => $this->subject,
            'payload' => $this->payload
        ]);

        throw new NotImplementedException('SqsGetJob Not Implemented');
    }
}
