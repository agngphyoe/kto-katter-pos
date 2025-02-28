<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestFormOneFromProfile extends FormRequest
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
            'email' => ['nullable', 'string', 'max:20', 'unique:users,email,' . $user_id],
            'nrc' => ['nullable', 'string', 'max:30', 'unique:users,nrc,' . $user_id],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone,' . $user_id],
        ];
    }
}
