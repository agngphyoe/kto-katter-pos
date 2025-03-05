<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $this->route('category')->id],
            'prefix' => ['nullable', 'max:255', 'unique:categories,prefix'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a valid string.',
            'name.max' => 'The category name must not exceed 255 characters.',
            'name.unique' => 'This category name already exists.',

            // 'prefix.required' => 'The prefix is required.',
            // 'prefix.max' => 'The prefix must not exceed 255 characters.',
            // 'prefix.unique' => 'This prefix already exists.',
        ];
    }
}
