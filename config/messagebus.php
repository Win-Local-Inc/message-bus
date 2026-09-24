<?php

return [
    'handlers' => env('AWS_SQS_HANDLER_PATHS', '') === '' ? [] : array_map('trim', explode(',', env('AWS_SQS_HANDLER_PATHS', ''))),
    'validators' => env('AWS_SQS_VALIDATOR_PATHS', '') === '' ? [] : array_map('trim', explode(',', env('AWS_SQS_VALIDATOR_PATHS', ''))),
    // Backed enum class, or a list of them checked in order.
    'subject_enum' => \WinLocal\MessageBus\Enums\WinlocalSubject::class,
];
