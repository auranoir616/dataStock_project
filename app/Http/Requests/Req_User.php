<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Req_User extends FormRequest
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
            'newName' => 'required','min:4','max:50',
            'newUsername' =>'required','min:4','max:12',Rule::unique('users','username'),
            'newPassword' => 'required',
            'newAccess' =>'required',
            'newPhoto' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048'

        ];[
            'newName.required' =>'>Name must be filled ',
            'newUsername.required' =>'>Usename must be filled ',
            'newPassword.required' =>'>email must be filled ',
            'newAccess.required' =>'>password must be filled ',
            'newPhoto.required' =>'>images must be filled '
        ];
    }
}
