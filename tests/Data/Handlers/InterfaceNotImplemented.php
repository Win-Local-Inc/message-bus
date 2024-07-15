<?php

namespace WinLocal\MessageBus\Tests\Data\Handlers;

use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Enums\WinlocalSubject;
use WinLocal\MessageBus\Jobs\SnsSendJob;

#[HandleSubjects(WinlocalSubject::AudienceDeleted)]
class InterfaceNotImplemented
{
    public function execute(WinlocalSubject $subject, array $payload): void
    {
        SnsSendJob::dispatch(WinlocalSubject::AudienceDeleted, [
            'context' => $payload['context'],
            'context_id' => $payload['context_id'],
            'user_id' => $payload['user_id'],
            'workspace_id' => $payload['workspace_id'],
            'data' => $payload['data'],
        ]);
    }
}
