<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserNotificationRequest extends FormRequest
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
            'mensaje' => ['sometimes', 'string', 'min:3', 'max:1000'],
            'fecha' => ['sometimes', 'date'],
            'leida' => ['sometimes', 'boolean'],
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
            'mensaje.min' => 'El mensaje debe tener al menos :min caracteres',
            'mensaje.max' => 'El mensaje no puede exceder :max caracteres',
            'fecha.date' => 'La fecha debe ser una fecha válida',
            'leida.boolean' => 'El campo leída debe ser verdadero o falso',
        ];
    }
}
