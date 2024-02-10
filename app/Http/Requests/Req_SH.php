<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_SH extends FormRequest
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
            'SHShipping_id'=>'required',
            'SHReceipt'=>'required',
            'SHDestination'=>'required',
            'SHName'=>'required',
            'SHExpedition'=>'required',
            'SHShippingCost' => 'required',
            'SHFile'=>'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'SHNotes' =>'nullable',
            'SHSKU'=>'required',
            'SHPrice'=>'required',
            'SHProduct'=>'required',
            'SHQuantity'=>'required',
            'SHDiscount'=>'required',
            'SHTotal_cost'=>'nullable',
            'SHTax'=>'nullable',
        ];
    }
}
