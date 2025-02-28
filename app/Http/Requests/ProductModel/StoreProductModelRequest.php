<?php

namespace App\Http\Requests\ProductModel;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductModelRequest extends FormRequest
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
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255', 'unique:product_models,name,NULL,id,brand_id,' . $this->input('brand_id'),],
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

            'brand_id.required' => 'The brand name is required.',
            'brand_id.exists' => 'The selected brand does not exist.',

            'name.required' => 'The product model name is required.',
            'name.string' => 'The product model name must be a valid string.',
            'name.max' => 'The product model name must not exceed 255 characters.',
            'name.unique' => 'This product model name already exists for the selected brand.',

        ];
    }
}
