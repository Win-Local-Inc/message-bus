<?php

namespace WinLocal\MessageBus\Tests\Data\Handlers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\SubjectEnum;
use WinLocal\MessageBus\Enums\AWSSubject;

#[HandleSubjects(AWSSubject::LambdaRekognitionFaceDetection)]
class RekognitionFaceDetection implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public static ?SubjectEnum $handledSubject = null;

    public static ?array $handledPayload = null;

    public function __construct(protected SubjectEnum $subject, protected array $payload)
    {
    }

    public function handle(): void
    {
        self::$handledSubject = $this->subject;
        self::$handledPayload = $this->payload;
    }
}
