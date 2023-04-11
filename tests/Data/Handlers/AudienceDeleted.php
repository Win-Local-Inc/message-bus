<?php

namespace WinLocal\MessageBus\Tests\Data\Handlers;

use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\ExecutorInterface;
use WinLocal\MessageBus\Enums\Subject;

#[HandleSubjects(Subject::AudienceDeleted, Subject::AudienceCreated)]
class AudienceDeleted implements ExecutorInterface
{
    public function execute(Subject $subject, array $payload): void
    {

        // SnsSendJob::dispatch('advert.facebook.created', [
        //     'context' => ['type' => 'Advert'],
        //     'context_id' => $advertSettings->getPackageId(),
        //     'user_id' => $user->id,
        //     'workspace_id' => $payload['workspace_id'],
        //     'data' => $state,
        // ]);
    }
}
