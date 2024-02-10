<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_PO extends FormRequest
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
            'POId' => 'required',
            'POCreateDate' => 'required',
            'POInvoice' => 'required',
            'POSupplier' => 'required',
            'POSKU' => 'required',
            'POQuantity' => 'required',
            'PONotes' => 'nullable',
            'POPrice'=>'required',
            'PODiscount' => 'nullable',
            'POTax' => 'nullable',
            'POTotalCost' => 'nullable',
            'POFile' =>'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ];[
            'POId.required' => 'PO ID must be filled',
            'POCreateDate.required' => 'Date must be filled',
            'POInvoice.required' => 'Invoice must be filled',
            'POSupplier.required' => 'Supplier must be filled',
            'POSKU.required' => 'SKU must be filled',
            'POPrice.required' =>'Price must be filled',
            'POQuantity.required' => 'Quantity must be filled',
            'POPayment.required' => 'Payment must be filled',
        ];
    }
}
