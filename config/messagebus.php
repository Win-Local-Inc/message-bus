<?php

return [
    'handlers' => env('AWS_SQS_HANDLER_PATHS', '') === '' ? [] : array_map('trim', explode(',', env('AWS_SQS_HANDLER_PATHS', ''))),
    'validators' => env('AWS_SQS_VALIDATOR_PATHS', '') === '' ? [] : array_map('trim', explode(',', env('AWS_SQS_VALIDATOR_PATHS', ''))),
];
