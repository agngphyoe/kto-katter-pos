<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBankAccount implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^\d+$/', $value);
    }

    public function message()
    {
        return 'The account number must be a valid numeric value.';
    }
}
