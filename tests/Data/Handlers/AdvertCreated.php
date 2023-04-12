<?php

namespace WinLocal\MessageBus\Tests\Data\Handlers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Enums\Subject;
use WinLocal\MessageBus\Jobs\SnsSendJob;

#[HandleSubjects(Subject::AdvertCreated, Subject::AdvertUpdated)]
class AdvertCreated implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected Subject $subject, protected array $payload)
    {
    }

    public function handle()
    {
        SnsSendJob::dispatch(Subject::AdvertCreated, [
            'context' => $this->payload['context'],
            'context_id' => $this->payload['context_id'],
            'user_id' => $this->payload['user_id'],
            'workspace_id' => $this->payload['workspace_id'],
            'data' => $this->payload['data'],
        ]);
    }
}
