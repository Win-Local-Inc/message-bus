<?php

namespace WinLocal\MessageBus\Contracts;

use WinLocal\MessageBus\Enums\Subject;

interface ExecutorResolverInterface
{
    public function getExecutorsBySubject(Subject $subject, array $paths): array;
}
