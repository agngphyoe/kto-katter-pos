<?php

namespace App\Http\Requests\CashBook\AccountType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateAccountRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'account_type_id' => ['required', 'integer', 'exists:account_types,id'],
            'account_number' => ['required', 'regex:/^\d+$/'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $exists = DB::table('accounts')
                ->where('name', $this->input('name'))
                ->where('account_type_id', $this->input('account_type_id'))
                ->where('account_number', $this->input('account_number'))
                ->where('id', '<>', $this->route('account')->id)
                ->exists();

            if ($exists) {
                $validator->errors()->add('duplicate_account', 'Duplicate account details are not allowed.');
            }
        });
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The account name is required.',
            'account_type_id.required' => 'The account type is required.',
            'account_type_id.exists' => 'The selected account type does not exist.',
            'account_number.required' => 'The account number is required.',
            'account_number.regex' => 'Special characters and alphabets are not allowed in account number.',
            'duplicate_account' => 'Duplicate account details are not allowed.',
        ];
    }
}
