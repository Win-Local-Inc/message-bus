<?php

namespace WinLocal\MessageBus\Contracts;

interface ExecutorResolverInterface
{
    public function getExecutorsBySubject(SubjectEnum $subject, array $paths): array;
}
