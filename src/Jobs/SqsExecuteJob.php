<?php

namespace WinLocal\MessageBus\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WinLocal\MessageBus\Contracts\SubjectEnum;

class SqsExecuteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected string $class,
        protected SubjectEnum $subject,
        protected array $payload
    ) {
    }

    public function handle()
    {
        $instance = resolve($this->class);
        $instance->execute($this->subject, $this->payload);
    }
}
