<?php

namespace WinLocal\MessageBus\Contracts;

interface MessageClientInterface
{
    public function publish(string $subject, array $message): void;
}
