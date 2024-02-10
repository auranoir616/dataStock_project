<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_Order extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ORSKU' => 'required',
            'ORProduct' => 'required',
            'ORPrice' => 'required',
            'ORQuantity' => 'required',
            'ORDiscount' => 'required',
            'ORID' => 'required',
            'ORSubtotal' => 'nullable',
            'ORCast' => 'nullable',
            'ORTax' => 'nullable'

        ];
    }
}
