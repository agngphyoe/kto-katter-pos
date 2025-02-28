<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnauthorizedException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Unauthorized',
            'status' => Response::HTTP_UNAUTHORIZED,
        ], Response::HTTP_UNAUTHORIZED);
    }
}
