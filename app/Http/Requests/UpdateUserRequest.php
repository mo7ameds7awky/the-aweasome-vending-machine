<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'username' => ['nullable', 'string', 'min:6', 'max:60', 'unique:users,username'],
            'password' => ['nullable', 'confirmed', Password::min(6)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(), 'max:60'],
            'deposit' => ['nullable', 'numeric', 'integer', 'in:5,10,20,50,100'],
            'userRoleId' => ['nullable', 'numeric', 'integer', 'exists:user_roles,id'],
        ];
    }
}
