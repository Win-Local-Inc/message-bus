<?php

namespace WinLocal\MessageBus\Contracts;

interface ExecutorInterface
{
    public function execute(SubjectEnum $subject, array $payload): void;
}
