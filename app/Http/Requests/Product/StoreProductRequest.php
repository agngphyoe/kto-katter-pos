<?php

namespace App\Http\Requests\Product;

use App\Constants\PrefixCodeID;
use App\Models\ProductPrefix;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $product_prefix = ProductPrefix::first();
        $code_lenght = $product_prefix?->prefix_length ?? PrefixCodeID::PREFIX_DEFAULT_LENGTH;

        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'model_id' => ['required', 'exists:product_models,id'],
            'type_id' => [ 'exists:types,id'],
            'design_id' => [ 'exists:designs,id'],
            'minimum_quantity' => ['required', 'numeric'],
            'image' => ['nullable', 'file'],
        ];
    }
}
