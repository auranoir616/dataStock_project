<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_EditPO extends FormRequest
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
            
            'editPOId' => 'required',
            'editPOCreateDate' => 'required',
            'editPOInvoice' => 'required',
            'editPOSupplier' => 'required',
            'editPOSKU' => 'required',
            'editPOQuantity' => 'required',
            'editPOPayment' => 'required',
            'editPOStatus' => 'nullable',
            'editPONotes' => 'nullable',
            'POFileEdit' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048'
    
        ];
    }
}
