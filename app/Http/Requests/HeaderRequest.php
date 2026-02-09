<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderRequest extends FormRequest
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
        $id = $this->route('header');
        $rules = [
            'description' => ['required', 'string', 'max:50'],
            'caption' => ['required', 'string', 'max:25'],
        ];

        $imageRules = [
            'image',
            'mimes:jpeg,png,jpg,webp',
            'max:2048',
        ];

        if ($id) {
            $rules['image_file'] = ['nullable', ...$imageRules];
        } else  {
            $rules['image_file'] = ['required', ...$imageRules];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'description' => 'Ingrese nueva descripción para el header',
            'image_file' => 'Debe agregar una imagen',
            'caption' => 'Debe agregar pie de imagen',
        ];
    }
}
