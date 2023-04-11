<?php

namespace WinLocal\MessageBus\Contracts;

use WinLocal\MessageBus\Enums\Subject;

interface ExecutorInterface
{
    public function execute(Subject $subject, array $payload): void;
}
