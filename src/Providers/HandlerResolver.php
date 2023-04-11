<?php

namespace WinLocal\MessageBus\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;
use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\HandlerResolverInterface;
use WinLocal\MessageBus\Enums\Subject;

class HandlerResolver implements HandlerResolverInterface
{
    protected ?Subject $subject = null;

    public function getHandlersBySubject(Subject $subject, array $paths): array
    {
        $this->subject = $subject;

        return Collection::make($paths)
            ->map(function (string $path) {
                return Collection::make($this->getAllFiles($path))
                    ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'php')
                    ->map(fn (SplFileInfo $file) => $this->createClassName($file))
                    ->filter(fn (string $absoluteClassName) => $this->classHandleSubject($absoluteClassName));
            })
            ->flatten()
            ->toArray();
    }

    protected function getAllFiles(string $path): array
    {
        return File::allFiles(App::path($path));
    }

    protected function createClassName(SplFileInfo $file): string
    {
        return ucfirst(
            str_replace([App::basePath().DIRECTORY_SEPARATOR, '/'], ['', '\\'], $file->getPath())
        ).'\\'.$file->getFilenameWithoutExtension();
    }

    protected function classHandleSubject(string $absoluteClassName): bool
    {
        $attributes = (new ReflectionClass($absoluteClassName))
            ->getAttributes(HandleSubjects::class);

        return array_key_exists(0, $attributes) ? in_array($this->subject, $attributes[0]->getArguments()) : false;
    }
}
