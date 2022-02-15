<?php

return [
    'path' => env('WINLOCAL_MESSAGEBUS_PATH', 'aws-sns-webhook'),
    'awsAccesKey' => env('AWS_ACCESS_KEY_ID'),
    'awsSecretKey' => env('AWS_SECRET_ACCESS_KEY'),
    'awsReqion' => env('AWS_REGION'),
    'awsSnsTopic' => env('AWS_SNS_TOPIC'),
];
