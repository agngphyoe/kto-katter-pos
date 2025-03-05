<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateRequest extends FormRequest
{
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
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('staffs', 'name')->ignore($this->route('staff')->id)],
            'position_id' => ['required', 'exists:positions,id'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('staffs', 'phone')->ignore($this->route('staff')->id)],
            'password' => ['nullable', 'string', 'min:8', 'same:confirm_password'],
            'confirm_password' => ['nullable', 'same:password', 'min:8'],
            'division_id' => ['nullable', 'integer'],
            'township_id' => ['nullable', 'integer'],
        ];
    }
}
