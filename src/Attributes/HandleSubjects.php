<?php

namespace WinLocal\MessageBus\Attributes;

use Attribute;
use WinLocal\MessageBus\Contracts\SubjectEnum;

#[Attribute(Attribute::TARGET_CLASS)]
class HandleSubjects
{
    public array $subjects;

    public function __construct(SubjectEnum ...$subjects)
    {
        $this->subjects = $subjects;
    }
}
