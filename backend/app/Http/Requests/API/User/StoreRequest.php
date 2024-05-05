<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
            'title' => 'required|string',
            'full_name' => 'required|string',
            'phone_number' => 'required|string|regex:/^\+?\d{10,}$/',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()]
        ];
    }
}
