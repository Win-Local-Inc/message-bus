<?php

namespace WinLocal\MessageBus\Contracts;

interface ExecutorInterface
{
    public function execute(string $subject, array $payload): void;
}
