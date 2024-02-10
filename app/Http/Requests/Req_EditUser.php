<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Req_EditUser extends FormRequest
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
            'editName' => ['nullable'],
            'editUsername' => ['nullable', 'min:4', 'max:12', Rule::unique('users', 'username')->ignore($this->request->get('editUsername'))],
            'editPassword' => ['nullable'],
            'editAccess' => ['nullable'],
            'editPhoto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }
    }
