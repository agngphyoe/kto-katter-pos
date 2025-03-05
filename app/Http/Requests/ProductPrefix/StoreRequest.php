<?php

namespace App\Http\Requests\ProductPrefix;

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
            'prefix'        => ['required', 'string', 'min:1', 'unique:product_prefixs,prefix'],
            'prefix_length' => ['required', 'min:1', 'max:4'],
        ];
    }
}
