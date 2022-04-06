<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:6', 'max:60', 'unique:users,username'],
            'password' => ['required', 'confirmed', Password::min(6)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(), 'max:60'],
            'deposit' => ['nullable', 'numeric', 'integer', 'in:5,10,20,50,100'],
            'roleName' => ['required', 'string', 'in:seller,buyer'],
        ];
    }
}
