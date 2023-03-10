<?php

namespace Project4\Exception;

use InvalidArgumentException;

class InvalidDataException extends InvalidArgumentException
{
    private array $errors = [];

    public function getDataErrors(): array
    {
        return $this->errors;
    }
    public static function fromErrors(array $errors): self
    {
        $exception = new self('invalid data exception');
        $exception->errors = $errors;

        return $exception;
    }
}
