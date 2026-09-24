<?php

namespace WinLocal\MessageBus\Enums;

use WinLocal\MessageBus\Contracts\SubjectEnum;

enum AWSSubject: string implements SubjectEnum
{
    case LambdaRekognitionFaceDetection = 'lambda.rekognition.face-detection';
}
