<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $current_id = $this->route('customer')->id;


        return [
            'name' => ['required', 'string', 'max:255'],
            'user_number' => ['required', 'string', 'max:255', 'unique:customers,user_number,' . $current_id],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone,' . $current_id],
            'email' => ['nullable', 'string', 'email', 'unique:customers,email,' . $current_id],
            'address' => ['nullable', 'string', 'max:255'],
            'township_id' => ['required', 'exists:townships,id'],
            'division_id' => ['required', 'exists:divisions,id'],
            'shop' => ['nullable', 'string'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20', 'unique:customers,contact_phone,' . $current_id],
            'contact_position' => ['nullable', 'string', 'max:20'],
        ];
    }
}
