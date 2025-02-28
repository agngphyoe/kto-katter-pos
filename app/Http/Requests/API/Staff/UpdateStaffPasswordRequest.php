<?php

namespace App\Http\Requests\API\Staff;

use App\Actions\HandleApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffPasswordRequest extends FormRequest
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
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
            // 'confirm_password' => ['nullable', 'same:new_password', 'min:8'],
        ];

        $this->validate(rules: $rules);

        return [];
    }
}
