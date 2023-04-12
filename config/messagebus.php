<?php

return [
    'handlers' => array_map('trim', explode(',', env('AWS_SQS_HANDLER_PATHS'))),
    'validators' => array_map('trim', explode(',', env('AWS_SQS_VALIDATOR_PATHS'))),
];
