<?php

namespace WinLocal\MessageBus\Tests\Unit;

use WinLocal\MessageBus\Enums\AWSSubject;
use WinLocal\MessageBus\Enums\SharetagSubject;
use WinLocal\MessageBus\Enums\WinlocalSubject;
use WinLocal\MessageBus\Support\SubjectResolver;
use WinLocal\MessageBus\Tests\TestCase;

class SubjectResolverTest extends TestCase
{
    public function test_single_enum_config_still_resolves(): void
    {
        config(['messagebus.subject_enum' => WinlocalSubject::class]);

        $this->assertSame(
            WinlocalSubject::AdvertCreated,
            SubjectResolver::tryFrom(WinlocalSubject::AdvertCreated->value)
        );
    }

    public function test_multiple_enums_are_checked_in_order(): void
    {
        config(['messagebus.subject_enum' => [
            WinlocalSubject::class,
            SharetagSubject::class,
        ]]);

        $this->assertSame(
            SharetagSubject::LambdaMediaCreated,
            SubjectResolver::tryFrom(SharetagSubject::LambdaMediaCreated->value)
        );
    }

    public function test_job_tag_matches_enum_value_before_colon(): void
    {
        config(['messagebus.subject_enum' => AWSSubject::class]);

        $this->assertSame(
            AWSSubject::LambdaRekognitionFaceDetection,
            SubjectResolver::tryFrom('', [
                'JobTag' => 'lambda.rekognition.face-detection:42',
            ])
        );
    }

    public function test_subject_with_colon_matches_prefix(): void
    {
        config(['messagebus.subject_enum' => AWSSubject::class]);

        $this->assertSame(
            AWSSubject::LambdaRekognitionFaceDetection,
            SubjectResolver::tryFrom('lambda.rekognition.face-detection:42')
        );
    }

    public function test_unknown_subject_returns_null(): void
    {
        config(['messagebus.subject_enum' => WinlocalSubject::class]);

        $this->assertNull(SubjectResolver::tryFrom('missing.subject', [
            'JobTag' => 'also-missing:1',
        ]));
    }
}
