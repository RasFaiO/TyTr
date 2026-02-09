<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        /** @var \Illuminate\Http\request $this */
        $id = $this->route('users');
        $rules = [
            'name' => ['required', 'string', 'min:10'],
            'email' => ['required', 'regex:/^[\w\.-]+@([\w-]+\.)+[a-zA-Z]{2,}$/', 'unique:users,email,' . $id],
            'password' => ['required', 'confirmed', Password::min(6)->mixedCase()->numbers()->symbols()]
        ];
        return $rules;
    }

    public function messages() : array {
        return [
            'name' => 'Ingrese nombre del usuario',
            'name.min' => 'El nombre no es válido',
            'email' => 'Ingrese el email del usuario',
            'email.unique' => 'El email ya existe',
            'email.regex' => 'El email no es válido',
        ];
    }
}
