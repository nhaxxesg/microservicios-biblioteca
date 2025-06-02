<?php

namespace App\Http\Requests;

use App\Models\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestValidation extends FormRequest
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
            'estado' => ['sometimes', 'required', Rule::in(Request::ESTADOS)],
            'prestamo_id' => ['sometimes', 'required', 'integer', 'min:1'],
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
            'estado.required' => 'El estado es requerido',
            'estado.in' => 'El estado proporcionado no es válido',
            'prestamo_id.required' => 'El ID de préstamo es requerido',
            'prestamo_id.integer' => 'El ID de préstamo debe ser un número entero',
            'prestamo_id.min' => 'El ID de préstamo no es válido',
        ];
    }
}
