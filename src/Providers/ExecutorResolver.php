<?php

namespace WinLocal\MessageBus\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;
use WinLocal\MessageBus\Attributes\HandleSubjects;
use WinLocal\MessageBus\Contracts\ExecutorResolverInterface;
use WinLocal\MessageBus\Enums\Subject;

class ExecutorResolver implements ExecutorResolverInterface
{
    protected ?Subject $subject = null;

    public function getExecutorsBySubject(Subject $subject, array $paths): array
    {
        $this->subject = $subject;

        return Collection::make($paths)
            ->map(fn (string $path) => Collection::make($this->getAllFiles($path))
                    ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'php')
                    ->map($this->createClassName(...))
                    ->filter($this->classHandleSubject(...)))
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
