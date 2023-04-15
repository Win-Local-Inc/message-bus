<?php

namespace WinLocal\MessageBus\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        if (! $this->subjectCanBeHandled($this->subject)) {
            return Log::error('SqsGetJob subject not in enums : '.$this->subject, ['payload' => $this->payload]);
        }

        $subject = Subject::from($this->subject);
        $this->validators($resolver, $subject);
        $this->handlers($resolver, $subject);
    }

    protected function validators(ExecutorResolverInterface $resolver, Subject $subject)
    {
        $classes = $resolver->getExecutorsBySubject($subject, config('messagebus.validators'));

        foreach ($classes as $class) {
            if ($this->extendsAbstractExecutorValidator(new ReflectionClass($class))) {
                $instance = resolve($class);
                $instance->execute($subject, $this->payload);
            }
        }
    }

    protected function handlers(ExecutorResolverInterface $resolver, Subject $subject)
    {
        $classes = $resolver->getExecutorsBySubject($subject, config('messagebus.handlers'));

        foreach ($classes as $class) {
            $reflector = new ReflectionClass($class);
            if ($this->extendsAbstractExecutorValidator($reflector)) {
                continue;
            } elseif ($this->isLaravelJob($reflector)) {
                $class::dispatch($subject, $this->payload);
            } elseif ($this->implementsExecutorInterface($reflector)) {
                SqsExecuteJob::dispatch($class, $subject, $this->payload);
            } else {
                throw new SqsJobInterfaceNotImplementedException($this->subject);
            }
        }
    }

    protected function subjectCanBeHandled(string $subject): bool
    {
        return collect(Subject::cases())
            ->contains(fn ($instance) => $instance->value === $subject);
    }

    protected function extendsAbstractExecutorValidator(ReflectionClass $reflector): bool
    {
        $parent = $reflector->getParentClass();
        while ($parent) {
            if ($parent->getName() === AbstractExecutorValidator::class) {
                return true;
            }
        }

        return false;
    }

    protected function isLaravelJob(ReflectionClass $reflector)
    {
        $useDispachable = false;
        $parent = $reflector;
        do {
            if (array_key_exists(Dispatchable::class, $parent->getTraits())) {
                $useDispachable = true;
                break;
            }
            $parent = $parent->getParentClass();
        } while ($parent);

        return $useDispachable
            && array_key_exists(ShouldQueue::class, $reflector->getInterfaces());
    }

    protected function implementsExecutorInterface(ReflectionClass $reflector): bool
    {
        return array_key_exists(ExecutorInterface::class, $reflector->getInterfaces());
    }
}
