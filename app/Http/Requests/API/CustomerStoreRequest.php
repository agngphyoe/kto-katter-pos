<?php

namespace App\Http\Requests\API;

use App\Actions\HandleApiValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerStoreRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'address' => ['nullable', 'string', 'max:255'],
            'township' => ['required'],
            'division' => ['required'],
            'shop' => ['nullable', 'string'],
        ];

        $this->validate(rules: $rules);

        return [];
    }
}
