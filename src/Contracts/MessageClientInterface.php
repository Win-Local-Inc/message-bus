<?php

namespace WinLocal\MessageBus\Contracts;

use WinLocal\MessageBus\Enums\Subject;

interface MessageClientInterface
{
    public function publish(Subject $subject, array $message): void;
}
