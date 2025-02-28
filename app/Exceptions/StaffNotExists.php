<?php

namespace App\Exceptions;

use App\Actions\HandlerResponse;
use Exception;
use Illuminate\Http\Response;

class StaffNotExists extends Exception
{
    use HandlerResponse;

    public function render()
    {
        return $this->responseUnauthorized(message: 'Staff does not exists', status_code: Response::HTTP_NOT_FOUND);
    }
}
