<?php

return [
    // resolved by App::path($path)
    'handlers' => array_map('trim', explode(',', env('AWS_SQS_HANDLER_PATHS'))),
];
