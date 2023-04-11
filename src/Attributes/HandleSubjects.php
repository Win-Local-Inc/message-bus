<?php

namespace WinLocal\MessageBus\Attributes;

use Attribute;
use WinLocal\MessageBus\Enums\Subject;

#[Attribute(Attribute::TARGET_CLASS)]
class HandleSubjects
{
    public function __construct(
        public Subject ...$subjects
    ) {
    }
}
