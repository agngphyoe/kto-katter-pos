<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:staffs'],
            'position_id' => ['required', 'exists:positions,id'],
            'phone' => ['required', 'string', 'max:20', 'unique:staffs'],
            'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
            'confirm_password' => ['required', 'same:password', 'min:8'],
            'division_id' => ['nullable', 'integer'],
            'township_id' => ['nullable', 'integer'],
        ];
    }
}
