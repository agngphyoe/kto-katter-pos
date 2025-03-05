<?php

namespace App\Http\Requests\User;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class FirstFormEditRequest extends FormRequest
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
        $user_id = $this->input('user_id');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user_id],
            // 'user_number' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'same:confirm_password'],
            'confirm_password' => ['nullable', 'same:password', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user_id],
            'email' => ['nullable', 'string', 'max:20', 'unique:users,email,' . $user_id],
            'role_id' => ['required', 'exists:roles,id'],
            'nrc' => ['nullable', 'unique:users,nrc,' . $user_id],
            'image' => ['nullable', 'file'],
        ];
    }
}
