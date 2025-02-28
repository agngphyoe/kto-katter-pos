<?php

namespace App\Http\Requests\API\Auth;

use App\Actions\HandleApiValidation;
use App\Actions\HandlerResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    use HandleApiValidation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ];

        $this->validate(rules: $rules);

        return [];
    }
}
