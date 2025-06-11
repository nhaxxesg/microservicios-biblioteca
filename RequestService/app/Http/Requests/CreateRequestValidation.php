<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // La autorización se maneja a través de middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'min:1'],
            'descripcion' => ['required', 'string', 'min:10', 'max:1000'],
            'book_id' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'usuario_id.required' => 'El ID de usuario es requerido',
            'usuario_id.integer' => 'El ID de usuario debe ser un número entero',
            'usuario_id.min' => 'El ID de usuario no es válido',
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.min' => 'La descripción debe tener al menos :min caracteres',
            'descripcion.max' => 'La descripción no puede exceder :max caracteres',
        ];
    }
}
