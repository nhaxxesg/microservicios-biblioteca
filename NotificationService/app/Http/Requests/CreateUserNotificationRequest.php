<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserNotificationRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'min:1'],
            'mensaje' => ['required', 'string', 'min:3', 'max:1000'],
            'fecha' => ['sometimes', 'date'],
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
            'user_id.required' => 'El ID de usuario es requerido',
            'user_id.integer' => 'El ID de usuario debe ser un número entero',
            'user_id.min' => 'El ID de usuario no es válido',
            'mensaje.required' => 'El mensaje es requerido',
            'mensaje.min' => 'El mensaje debe tener al menos :min caracteres',
            'mensaje.max' => 'El mensaje no puede exceder :max caracteres',
            'fecha.date' => 'La fecha debe ser una fecha válida',
        ];
    }
}
