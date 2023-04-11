<?php

namespace WinLocal\MessageBus\Attributes;

use WinLocal\MessageBus\Enums\Subject;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class HandleSubjects
{
    public function __construct(
        public Subject ...$subjects
    ) {
    }
}
