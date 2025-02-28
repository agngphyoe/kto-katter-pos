<?php

namespace App\Http\Requests\Sale;

use App\Constants\SaleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreFinalFormRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'invoice_number' => ['required', 'unique:sales'],
            'division' => ['required'],
            'township' => ['required'],
            'cash_down' => ['nullable', 'numeric', 'min:0'],
            // 'total_quantity' => ['required', 'numeric'],
            // 'total_amount' => ['required', 'numeric'],
            'action_type' => ['required'],
            'payment_type' => ['required'],
            'sale_process' => ['required'],
            'delivery_charges' => ['required'],
            'action_date' => ['required', 'date'],
            'due_date' => [
                'nullable',
                'date',
                Rule::requiredIf(function ()  use ($request) {

                    return $request->input('action_type') == SaleType::TYPES['Credit'];
                })
            ]
        ];
    }
}
