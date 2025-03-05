<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'user_number' => ['required', 'string', 'max:255','unique:suppliers'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'phone' => ['required', 'string', 'max:20'],
            'country_id' => ['required', 'exists:countries,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_position' => ['nullable', 'string', 'max:20']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The supplier name is required.',
            'user_number.required' => 'The user number is required.',
            'user_number.unique' => 'This user number is already taken by another supplier.',
            'phone.required' => 'The phone number is required.',
            'country_id.required' => 'Please select a country.',
            'contact_name.required' => 'The contact person\'s name is required.',
            'contact_phone.required' => 'The contact phone number is required.',
            'contact_position.max' => 'Contact position should not exceed 20 characters.',
            'image.mimes' => 'The image must be a file of type: png, jpg, jpeg.',
        ];
    }
}
