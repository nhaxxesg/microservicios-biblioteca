<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSancionRequest extends FormRequest
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
            'usuario_id' => 'required|integer|exists:users,id',
            'motivo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|string|in:activa,cumplida,cancelada,apelada'
        ];
    }

    public function messages()
    {
        return [
            'usuario_id.required' => 'El ID del usuario es requerido',
            'usuario_id.exists' => 'El usuario especificado no existe',
            'motivo.required' => 'El motivo es requerido',
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_fin.required' => 'La fecha de fin es requerida',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'estado.required' => 'El estado es requerido',
            'estado.in' => 'El estado debe ser: activa, cumplida, cancelada o apelada'
        ];
    }
}
