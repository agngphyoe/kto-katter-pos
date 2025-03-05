<?php

namespace App\Actions;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\UnprocessableException;
use Illuminate\Support\Facades\Validator;

trait HandleApiValidation
{
    use HandlerResponse;

    public function validate($rules)
    {
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {

            throw new UnprocessableException($validator->errors()->toArray());
        }

        return null;
    }
}
