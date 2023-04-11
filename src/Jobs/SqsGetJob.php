<?php

namespace WinLocal\MessageBus\Jobs;

use ReflectionClass;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use WinLocal\MessageBus\Enums\Subject;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use WinLocal\MessageBus\Contracts\ExecutorInterface;
use WinLocal\MessageBus\Contracts\HandlerResolverInterface;
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

    public function handle(HandlerResolverInterface $handler)
    {
        if(!$this->subjectCanBeHandled($this->subject)) {
            return Log::error('SqsGetJob subject not in enums : '. $this->subject, ['payload' => $this->payload]);
        }

        $classes = $handler->getHandlersBySubject(Subject::from($this->subject), config('messagebus.handlers'));

        foreach($classes as $class) {
            $interfaces = (new ReflectionClass($class))->getInterfaces();
            if(array_key_exists(Dispatchable::class, $interfaces)) {
                $class::dispatch($this->subject, $this->payload);
            } elseif(array_key_exists(ExecutorInterface::class, $interfaces)) {
                SqsJobExecute::dispatch($class, $this->subject, $this->payload);
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
}
