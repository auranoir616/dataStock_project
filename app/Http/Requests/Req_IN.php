<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_IN extends FormRequest
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
            'addInInvoice'=>'required',
            'addInIdInbound' => 'required',
            'addInIdPO' => 'required',
            'addInSKU' => 'required',
            'addInName'=>'required',
            'addInCategories' => 'required',
            'addInPrice' => 'required',
            'addInQuantity' => 'required',
            'addInUnit'=>'required',
            'addInNotes'=>'nullable',
            'addInFile'=>'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'addInCheck' => 'nullable'
        ];
    }
}
