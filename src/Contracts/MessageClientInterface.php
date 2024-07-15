<?php

namespace WinLocal\MessageBus\Contracts;

interface MessageClientInterface
{
    public function publish(SubjectEnum $subject, array $message): void;
}
