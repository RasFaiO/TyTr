<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        $id = $this->route('catService');
        $rules = [
            'name' => ['required','string','max:30','unique:services,name,' . $id],
            'excerpt' => ['required','string','max:300'],
            'description' => ['required', 'string', 'max:500'],
            'caption_image' => ['required', 'string', 'max:25'],
            'state' => ['boolean']
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
            'name' => 'Agregue el nombre del servicio',
            'name.unique' => 'El servicio ya existe',
            'excerpt' => 'Agregue descripción corta del servicio',
            'description' => 'Ingrese nueva descripción para el servicio',
            'image_file' => 'Debe agregar una imagen',
            'caption_image' => 'Debe agregar pie de imagen',
        ];
    }
}
