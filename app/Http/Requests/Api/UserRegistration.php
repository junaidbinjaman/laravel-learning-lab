<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistration extends FormRequest
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
            //
            'name' => 'required|min:4',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Name must be more than 4 char',
            'name.required' => 'Name cannot be empty',
            'email.unique' => 'The email is already taken',
            'email.required' => 'Email cannot be empty',
            'password.confirmed' => 'password didn\'t match'
        ];
    }
}
