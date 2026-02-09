<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceItemRequest extends FormRequest
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
        $id = $this->route('service_item');

        $rules = [
            'service_id' => ['required','numeric'],
            'slug' => ['required', 'string', 'max:255', 'unique:service_items,slug,'.$id],
            'description' => ['required', 'string', 'max:500'],
            'excerpt' => ['required', 'string', 'max:300'],
            'price' => ['required', 'numeric', 'min:1000'],
            'included' => ['required', 'string', 'max:500'],
            'duration' => ['required', 'string', 'max:50'],
            'state' => ['boolean'],
            'caption_image' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'capacity' => ['required', 'numeric', 'min:1'],
            'start_date' => ['required', 'date'],
            'featured' => ['boolean'],
            'position' => ['required', 'numeric'],
            'gallery' => ['array']
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

    public function messages(): array {
        return [
            'service_id' => 'Seleccione un servicio',
            'slug' => 'Registre un nombre',
            'slug.unique' => 'El subservicio ya existe',
            'description' => 'Agregue una descripción',
            'excerpt' => 'Agregue una descripción corta',
            'price' => 'Agregue un valor',
            'included' => 'Agregue por lo menos 1',
            'duration' => 'Cantidad de días',
            'caption_image' => 'falta nombre de imagen',
            'image_file' => 'Debe agregar una imagen',
            'location' => 'Agregue un lugar',
            'capacity' => 'Mínimo una persona',
            'start_date' => 'Seleccione Fecha válida',
        ];
    }
}
