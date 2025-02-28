<?php

namespace App\Http\Requests\User;

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
            // 'name' => ['required', 'string', 'max:255'],
            // 'user_number' => ['required', 'string', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8'],
            // 'confirm_password' => ['required', 'same:password', 'min:8'],
            // 'phone' => ['required', 'string', 'max:20', 'unique:users'],
            // 'email' => ['nullable', 'string', 'max:20', 'unique:users'],
            // 'role_id' => ['required', 'exists:roles,id'],
            // 'nrc' => ['nullable', 'unique:users'],
            'permissions' => ['nullable', 'array'],
        ];
    }
}
