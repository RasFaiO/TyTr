<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductItemRequest extends FormRequest
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
        $id = $this->route('product_item');

        $rules = [
            'product_id' => ['required', 'numeric'],
            'slug' => ['required', 'string', 'max:255', 'unique:product_items,slug,' . $id],
            'description' => ['required', 'string', 'max:500'],
            'excerpt' => ['required', 'string', 'max:300'],
            'price' => ['required', 'numeric', 'min:1000'],
            'stock' => ['required', 'numeric', 'min:1' ,'max:500'],
            'caption_image' => ['required', 'string', 'max:100'],
            'size' => ['nullable', 'string', 'max:10'],
            'weight' => ['nullable', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:20'],
            'unit' => ['nullable', 'string', 'in:unidad,docena,gramos,litros'],
            'state' => ['required', 'boolean'],
            'featured' => ['boolean']
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
            'product_id' => 'Seleccione un producto',
            'slug' => 'Registre un nombre',
            'description' => 'Agregue una descripción',
            'excerpt' => 'Agregue una descripción corta',
            'price' => 'Agregue un valor',
            'stock' => 'mínimo 1 producto',
            'caption_image' => 'falta nombre de imagen',
            'image_file' => 'Debe agregar una imagen',
            'size' => 'Indique la talla',
            'wieght' => 'peso (aproximado)',
            'color' => 'Indique color',
            'unit' => 'Seleccione unidad de medida',
        ];
    }
}
