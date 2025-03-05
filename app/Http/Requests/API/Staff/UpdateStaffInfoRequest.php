<?php

namespace App\Http\Requests\API\Staff;

use App\Actions\HandleApiValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffInfoRequest extends FormRequest
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
        $rules =  [
            'name' => ['required', 'string', 'max:225'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore(auth()->user()->id)],
        ];

        $this->validate(rules: $rules);

        return [];
    }
}
