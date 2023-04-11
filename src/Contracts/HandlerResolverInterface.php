<?php

namespace WinLocal\MessageBus\Contracts;

use WinLocal\MessageBus\Enums\Subject;

interface HandlerResolverInterface
{
    public function getHandlersBySubject(Subject $subject, array $paths): array;
}
