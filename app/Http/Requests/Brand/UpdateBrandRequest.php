<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,NULL,id,category_id,' . $this->route('category_id'),],
            'prefix' => ['nullable', 'max:255', 'unique:brands,prefix,NULL,id,category_id,'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => 'The category name is required.',
            'category_id.exists' => 'The selected category does not exist.',

            'name.required' => 'The brand name is required.',
            'name.string' => 'The brand name must be a valid string.',
            'name.max' => 'The brand name must not exceed 255 characters.',
            'name.unique' => 'This brand name already exists in the selected category.',

            // 'prefix.required' => 'The prefix is required.',
            // 'prefix.max' => 'The prefix must not exceed 255 characters.',
            // 'prefix.unique' => 'This prefix already exists in the selected category.',
        ];
    }
}
