<?php

namespace WinLocal\MessageBus\Tests\Data\Handlers;

use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Enums\Subject;
use WinLocal\MessageBus\Jobs\SnsSendJob;

#[HandleSubjects(Subject::AudienceDeleted)]
class InterfaceNotImplemented
{
    public function execute(Subject $subject, array $payload): void
    {
        SnsSendJob::dispatch(Subject::AudienceDeleted, [
            'context' => $payload['context'],
            'context_id' => $payload['context_id'],
            'user_id' => $payload['user_id'],
            'workspace_id' => $payload['workspace_id'],
            'data' => $payload['data'],
        ]);
    }
}
