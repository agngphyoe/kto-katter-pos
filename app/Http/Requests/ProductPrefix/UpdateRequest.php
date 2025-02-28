<?php

namespace App\Http\Requests\ProductPrefix;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $current_id = $this->route('prefix')->id;

        return [
            'prefix'        => ['required', 'string', 'min:1',   'unique:product_prefixs,prefix,' . $current_id],
            'prefix_length' => ['required', 'string', 'min:1', 'max:4'],
        ];
    }
}
