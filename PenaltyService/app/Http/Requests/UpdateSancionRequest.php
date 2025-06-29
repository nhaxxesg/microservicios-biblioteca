<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSancionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization will be handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => 'sometimes|integer',
            'motivo' => 'sometimes|string',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after:fecha_inicio',
            'estado' => 'sometimes|string|in:activa,cumplida,cancelada,apelada'
        ];
    }

    public function messages()
    {
        return [
            'book_id.integer' => 'El ID del libro debe ser un número entero',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'estado.in' => 'El estado debe ser: activa, cumplida, cancelada o apelada'
        ];
    }
}
