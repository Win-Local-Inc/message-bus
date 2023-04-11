<?php

namespace WinLocal\MessageBus\Providers;

use ReflectionClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use WinLocal\MessageBus\Enums\Subject;
use Symfony\Component\Finder\SplFileInfo;
use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\HandlerResolverInterface;

class HandlerResolver implements HandlerResolverInterface
{
    public function getHandlersBySubject(Subject $subject, array $paths): array
    {
        return Collection::make($paths)
            ->map(function (string $path) use (&$subject) {
                return Collection::make(File::allFiles(App::path($path)))
                    ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'php')
                    ->map(function (SplFileInfo $file) {
                        return ucfirst(
                            str_replace([App::basePath().DIRECTORY_SEPARATOR, '/'], ['','\\'], $file->getPath())
                        ).'\\'.$file->getFilenameWithoutExtension();
                    })
                    ->filter(function (string $absoluteClassName) use (&$subject) {
                        return in_array($subject, ...optional(
                            optional(
                                (new ReflectionClass($absoluteClassName))
                                ?->getAttributes(HandleSubjects::class)
                            )[0]?->getArguments()
                        ) ?? []);
                    });
            })
            ->flatten()
            ->toArray();
    }
}
