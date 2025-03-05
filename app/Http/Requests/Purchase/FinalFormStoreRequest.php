<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FinalFormStoreRequest extends FormRequest
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
            // 'payment_type' => ['required'],
            'action_type' => ['required'],
            'total_amount' => ['required', 'numeric'],
            'total_selling_amount' => ['required', 'numeric'],
            'total_quantity' => ['required', 'numeric'],
            // 'discount' => ['required_if:action_type,Cash'],
            'discount_amount' => ['nullable', 'numeric'],
            'action_date' => ['required', 'date'],
        ];
    }
}
