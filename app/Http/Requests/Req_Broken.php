<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Req_Broken extends FormRequest
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
            'brokenID' => 'required',
            'itemID' => 'nullable',
            'brokenSKU' => 'required',
            'brokenProduct' => 'required',
            'brokenQuantity' => 'required',
            'brokenNotes' => 'required',
            'brokenFile' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'brokenReference' => 'nullable',
        ];
    }
}
