<?php

namespace App\Http\Requests\CompanySettings;

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
            'name' => ['required', 'string', 'max:255', 'unique:company_settings,name'],
            'url' => ['required', 'string', 'unique:company_settings,url']
        ];
    }
}
