<?php

namespace WinLocal\MessageBus\Tests\Data\Validators;

use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\AbstractExecutorValidator;
use WinLocal\MessageBus\Enums\Subject;

#[HandleSubjects(Subject::AdvertCreated, Subject::AudienceUpdated)]
class AudienceCreated extends AbstractExecutorValidator
{
    protected function getRules(array $payload): array
    {
        return [
            'user_id' => 'required|uuid',
            'workspace_id' => 'required|uuid',
            'data.user_id' => 'required|uuid',
            'data.workspace_id' => 'required|uuid',
        ];
    }
}
