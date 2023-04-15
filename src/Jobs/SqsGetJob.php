<?php

namespace WinLocal\MessageBus\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use WinLocal\MessageBus\Contracts\AbstractExecutorValidator;
use WinLocal\MessageBus\Contracts\ExecutorInterface;
use WinLocal\MessageBus\Contracts\ExecutorResolverInterface;
use WinLocal\MessageBus\Enums\Subject;
use WinLocal\MessageBus\Exceptions\SqsJobInterfaceNotImplementedException;

class SqsGetJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Dispatchable;

    public function __construct(protected string $subject, protected array $payload)
    {
    }

    public function handle(ExecutorResolverInterface $resolver)
    {
        if (null === ($subject = Subject::tryFrom($this->subject))) {
            return Log::error('SqsGetJob subject not in enums : '.$this->subject, ['payload' => $this->payload]);
        }

        $this->validators($resolver, $subject);
        $this->handlers($resolver, $subject);
    }

    protected function validators(ExecutorResolverInterface $resolver, Subject $subject): void
    {
        $validatorPaths = Config::get('messagebus.validators');
        if (empty($validatorPaths)) {
            return;
        }

        $classes = $resolver->getExecutorsBySubject($subject, $validatorPaths);
        foreach ($classes as $class) {
            if ($this->extendsAbstractExecutorValidator(new ReflectionClass($class))) {
                $instance = resolve($class);
                $instance->execute($subject, $this->payload);
            }
        }
    }

    protected function handlers(ExecutorResolverInterface $resolver, Subject $subject): void
    {
        $handlerPaths = Config::get('messagebus.handlers');
        if (empty($handlerPaths)) {
            return;
        }

        $classes = $resolver->getExecutorsBySubject($subject, $handlerPaths);
        foreach ($classes as $class) {
            $reflector = new ReflectionClass($class);
            match (true) {
                $this->extendsAbstractExecutorValidator($reflector) => null,
                $this->isLaravelJob($reflector) => $class::dispatch($subject, $this->payload),
                $this->implementsExecutorInterface($reflector) => SqsExecuteJob::dispatch($class, $subject, $this->payload),
                default => throw new SqsJobInterfaceNotImplementedException($class.' - '.$this->subject)
            };
        }
    }

    protected function extendsAbstractExecutorValidator(ReflectionClass $reflector): bool
    {
        $parent = $reflector->getParentClass();
        while ($parent) {
            if ($parent->getName() === AbstractExecutorValidator::class) {
                return true;
            }
            $parent = $parent->getParentClass();
        }

        return false;
    }

    protected function isLaravelJob(ReflectionClass $reflector): bool
    {
        $parent = $reflector;
        do {
            if (array_key_exists(Dispatchable::class, $parent->getTraits())) {
                return array_key_exists(ShouldQueue::class, $reflector->getInterfaces());
            }
            $parent = $parent->getParentClass();
        } while ($parent);

        return false;
    }

    protected function implementsExecutorInterface(ReflectionClass $reflector): bool
    {
        return array_key_exists(ExecutorInterface::class, $reflector->getInterfaces());
    }
}
