<?php

namespace App\Http\Requests\CashBook\IncomeExpense;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomeExpenseRequest extends FormRequest
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
            'business_type_id' => ['required', 'integer', 'exists:business_types,id'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'bank_id' => ['required', 'integer', 'exists:banks,id'],
            'transaction_type' => ['required', 'string', 'in:income,expense'],
            'amount' => ['required', 'integer'],
            'description' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date']
        ];
    }
}
