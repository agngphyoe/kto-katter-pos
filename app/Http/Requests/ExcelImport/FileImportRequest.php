<?php

namespace App\Http\Requests\ExcelImport;

use Illuminate\Foundation\Http\FormRequest;

class FileImportRequest extends FormRequest
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

            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ];
    }
}
