<?php

namespace App\Exceptions;

use App\Actions\HandlerResponse;
use Exception;

class UnprocessableException extends Exception
{
    use HandlerResponse;

    public function __construct(public array $errors)
    {
    }

    public function render()
    {
        return $this->responseValidationErrors(errors: $this->errors);
    }
}
