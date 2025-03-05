<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'model_id' => ['required'],
            // 'type_id' => ['exists:types,id'],
            // 'design_id' => ['exists:designs,id'],
            // 'price' => ['required', 'numeric'],
            // 'quantity' => ['required', 'numeric'],
            'minimum_quantity' => ['required', 'numeric'],
            'image' => ['nullable'],
        ];
    }
}
