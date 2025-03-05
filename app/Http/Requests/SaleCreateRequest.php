<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class SaleCreateRequest extends FormRequest
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
            'data.order_id' => 'required|integer',
            'data.customer_id' => 'required|integer',
            'data.payment_type' => 'required|string',
            'data.action_date' => 'required|date_format:m/d/Y',
            'data.invoice_number' => 'required|string',
            'data.division' => 'required',
            'data.township' => 'required',
            'data.cash_down' => 'nullable|numeric',
            'data.due_date' => 'required|date_format:m/d/Y',
            'data.address' => 'required|string',
            'data.action_type' => 'required|in:Cash,Credit,Consignment',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                "status_code" =>  500,
                'message' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
