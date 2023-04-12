<?php

namespace WinLocal\MessageBus\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use WinLocal\MessageBus\Enums\Subject;

class SqsExecuteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected string $class,
        protected Subject $subject,
        protected array $payload
    ) {
    }

    public function handle()
    {
        try {
            $instance = resolve($this->class);
            $instance->execute($this->subject, $this->payload);
        } catch (Exception $exception) {
            Log::error('SqsExecuteJob '.$exception->getMessage(), [
                'exception' => $exception,
                'subject' => $this->subject->value,
                'message' => $this->payload,
            ]);
        }
    }
}
