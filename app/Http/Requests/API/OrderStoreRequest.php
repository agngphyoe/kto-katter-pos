<?php

namespace App\Http\Requests\API;

use App\Actions\HandleApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'customer_id' => ['required', 'exists:customers,id'],
            'order_request' => ['required', 'string'],
            'products' => ['required', 'array'],
            'products.*.id' => ['required', 'integer'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.price' => [ 'integer', 'min:1'],
            'location_id' => ['required'],
        ];

        $this->validate(rules: $rules);

        return [];
    }
}
