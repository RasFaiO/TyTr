<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactmeRequest extends FormRequest
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
            "name" => ["required", "string", "min:7","max:40"],
            "email" => ["required", "regex:/^[\w\.-]+@([\w-]+\.)+[a-zA-Z]{2,}$/"],
            "phone" => ["required", "string", "regex:/^\+?[0-9\-\s\(\)]{7,25}$/"],
            // "phone" => ["required", "string", "min:7", "max:10", "regex:/^(3\d{9}|60[1-9]\d{7})$/"],
            "subject" => ["required", "string"],
            "message" => ["required", "min:15"],
            "privacy" => ["required", "boolean", "accepted"]
        ];
    }

    public function messages(): array {
        return [
            "name.required" => "El nombre es oligatorio",
            "email.required" => "El email es obligatorio",
            "phone.required" => "El número de teléfono es obligatorio",
            "subject.required" => "El asunto es obligatorio",
            "message.required" => "El mensaje es obligatorio",
            "privacy.accepted" => "Debe confirmar la política de privacidad"
        ];
    }
}
