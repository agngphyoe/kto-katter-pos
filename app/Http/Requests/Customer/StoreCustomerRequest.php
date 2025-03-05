<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreCustomerRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'user_number' => ['required', 'string', 'max:255', 'unique:customers,user_number'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'email' => ['nullable', 'string', 'email', 'unique:customers,email'],
            'address' => ['nullable', 'string', 'max:255'],
            'township_id' => ['required'],
            'division_id' => ['required'],
            'shop' => ['nullable', 'string'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20', 'unique:customers,contact_phone'],
            'contact_position' => ['nullable', 'string', 'max:50'],
        ];
    }
}
