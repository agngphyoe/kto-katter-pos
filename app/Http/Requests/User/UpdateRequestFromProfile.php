<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestFromProfile extends FormRequest
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
        $user_id = $this->route('user')->id;

        return [
            'password' => ['nullable', 'string', 'min:8', 'same:confirm_password'],
            'confirm_password' => ['nullable', 'same:password', 'min:8'],
        ];
    }
}
