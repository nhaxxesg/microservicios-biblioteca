<?php

namespace App\Http\Requests;

use App\Models\Prestamo;
use Illuminate\Foundation\Http\FormRequest;

class StorePrestamo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'libro_id' => 'required|integer|exists:libros,id',
            'user_id' => 'required|integer|exists:users,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion_prevista' => 'required|date|after:fecha_prestamo',
            'estado' => 'required|string|in:' . implode(',', Prestamo::ESTADOS()),
            'sancion_id' => 'nullable|integer|exists:sanciones,id',
        ];
    }

    public function messages()
    {
        return [
            'libro_id.required' => 'El ID del libro es requerido',
            'libro_id.exists' => 'El libro seleccionado no existe',
            'user_id.required' => 'El ID del usuario es requerido',
            'user_id.exists' => 'El usuario seleccionado no existe',
            'fecha_prestamo.required' => 'La fecha de préstamo es requerida',
            'fecha_prestamo.date' => 'La fecha de préstamo debe ser una fecha válida',
            'fecha_devolucion_prevista.required' => 'La fecha de devolución prevista es requerida',
            'fecha_devolucion_prevista.date' => 'La fecha de devolución prevista debe ser una fecha válida',
            'fecha_devolucion_prevista.after' => 'La fecha de devolución debe ser posterior a la fecha de préstamo',
            'estado.required' => 'El estado es requerido',
            'estado.in' => 'El estado seleccionado no es válido',
        ];
    }
}
