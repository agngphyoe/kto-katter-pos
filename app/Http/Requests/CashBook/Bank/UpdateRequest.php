<?php

namespace App\Http\Requests\CashBook\Bank;

use App\Rules\ValidBankAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bank_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/\d/'
            ],
            'account_name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/\d/'
            ],
            'account_number' => [
                'required',
                'string',
                'regex:/^\d+$/',
                new ValidBankAccount
            ],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $bankId = $this->route('bank');

            $exists = DB::table('banks')
                ->where('bank_name', $this->input('bank_name'))
                ->where('account_name', $this->input('account_name'))
                ->where('account_number', $this->input('account_number'))
                ->where('id', '!=', $bankId)
                ->exists();

            if ($exists) {
                $validator->errors()->add('duplicate_account', 'This bank account already exists.');
            }
        });
    }

    public function messages()
    {
        return [
            'bank_name.required' => 'The bank name is required.',
            'bank_name.max' => 'Bank Name must not exceed 50 characters.',
            'bank_name.regex' => 'Special characters & numbers are not allowed in the bank name.',
            'bank_name.not_regex' => 'Bank Name must not contain numeric values.',

            'account_name.required' => 'The account name is required.',
            'account_name.max' => 'Account Name must not exceed 50 characters.',
            'account_name.regex' => 'Special characters & numbers are not allowed in the account name.',
            'account_name.not_regex' => 'Account Name must not contain numeric values.',

            'account_number.required' => 'The account number is required.',
            'account_number.regex' => 'Account number must contain only numbers, no letters or special characters.',
        ];
    }
}
