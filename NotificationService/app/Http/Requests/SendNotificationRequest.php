<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    public function authorize()
    {
        // Add your authorization logic here
        return true;
    }

    public function rules()
    {
        return [
            'event_source_id' => 'required|string|max:255',
            'event_type' => 'required|string|in:solicitud_creada,solicitud_estado_actualizado',
            'recipient_email' => 'required|email',
            'subject_override' => 'nullable|string|max:255',
            'template_data' => 'required|array',
            'template_data.nombre_usuario' => 'required|string',
            'template_data.id_solicitud_visible' => 'required|string',
            'template_data.descripcion_solicitud' => 'required|string',
            'template_data.link_detalle_solicitud' => 'required|url',
            'template_data.nuevo_estado' => 'required_if:event_type,solicitud_estado_actualizado',
            'send_async' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'event_type.in' => 'El tipo de evento debe ser: solicitud_creada o solicitud_estado_actualizado',
            'template_data.nombre_usuario.required' => 'El nombre del usuario es requerido',
            'template_data.id_solicitud_visible.required' => 'El ID visible de la solicitud es requerido',
            'template_data.descripcion_solicitud.required' => 'La descripción de la solicitud es requerida',
            'template_data.link_detalle_solicitud.required' => 'El enlace de detalle es requerido',
            'template_data.link_detalle_solicitud.url' => 'El enlace de detalle debe ser una URL válida',
            'template_data.nuevo_estado.required_if' => 'El nuevo estado es requerido cuando el tipo de evento es actualización de estado',
        ];
    }
}
