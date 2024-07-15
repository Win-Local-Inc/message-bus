<?php

namespace WinLocal\MessageBus\Contracts;

use Illuminate\Support\Facades\Validator;
use WinLocal\MessageBus\Exceptions\ExecutorValidatorException;

abstract class AbstractExecutorValidator implements ExecutorInterface
{
    public function execute(SubjectEnum $subject, array $payload): void
    {
        $this->validatePayload($payload);
    }

    protected function validatePayload(array $payload): void
    {
        $rules = $this->getRules($payload);
        if (empty($rules)) {
            return;
        }

        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            throw new ExecutorValidatorException(get_called_class().' SQS Validation - '.$validator->errors()->toJson());
        }
    }

    abstract protected function getRules(array $payload): array;
}
