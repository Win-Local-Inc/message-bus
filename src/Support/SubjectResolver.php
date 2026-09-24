<?php

namespace WinLocal\MessageBus\Support;

use WinLocal\MessageBus\Contracts\SubjectEnum;

class SubjectResolver
{
    public static function tryFrom(string $subject, array $payload = []): ?SubjectEnum
    {
        foreach (self::candidates($subject, $payload) as $candidate) {
            foreach (self::enumClasses() as $enum) {
                if ($resolved = $enum::tryFrom($candidate)) {
                    return $resolved;
                }
            }
        }

        return null;
    }

    /**
     * @return list<class-string<SubjectEnum>>
     */
    public static function enumClasses(): array
    {
        $configured = config('messagebus.subject_enum');
        $classes = is_array($configured) ? $configured : [$configured];

        return array_values(array_filter(
            $classes,
            fn ($class) => is_string($class) && is_a($class, SubjectEnum::class, true)
        ));
    }

    /**
     * @return list<string>
     */
    protected static function candidates(string $subject, array $payload): array
    {
        $values = [];

        if ($subject !== '') {
            $values[] = $subject;
        }

        $jobTag = $payload['JobTag'] ?? null;

        if (is_string($jobTag) && $jobTag !== '') {
            $values[] = $jobTag;
        }

        $candidates = [];

        foreach ($values as $value) {
            $candidates[] = $value;
            $colon = strpos($value, ':');

            if ($colon !== false && $colon > 0) {
                $candidates[] = substr($value, 0, $colon);
            }
        }

        return array_values(array_unique($candidates));
    }
}
