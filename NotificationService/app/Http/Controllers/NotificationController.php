<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendNotificationRequest;
use App\Jobs\SendNotificationJob;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function send(SendNotificationRequest $request)
    {
        // Implement idempotency check
        $idempotencyKey = $this->generateIdempotencyKey($request);
        $cachedResponse = Cache::get($idempotencyKey);
        
        if ($cachedResponse) {
            return response()->json($cachedResponse, 200);
        }

        try {
            $trackingId = (string) Str::uuid();
            
            // Create notification record
            $notification = Notification::create([
                'tracking_id' => $trackingId,
                'event_source_id' => $request->event_source_id,
                'event_type' => $request->event_type,
                'recipient_email' => $request->recipient_email,
                'subject' => $request->subject_override ?? $this->getDefaultSubject($request->event_type),
                'template_used' => $this->getTemplateName($request->event_type),
                'status' => 'encolado'
            ]);

            Log::info('Nueva solicitud de notificación recibida', [
                'tracking_id' => $trackingId,
                'event_type' => $request->event_type
            ]);

            $sendAsync = $request->input('send_async', true);
            $response = $this->processNotification($notification, $request->template_data, $sendAsync);

            // Cache the response for idempotency
            Cache::put($idempotencyKey, $response, now()->addMinutes(30));

            return response()->json($response, $sendAsync ? Response::HTTP_ACCEPTED : Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al procesar solicitud de notificación', [
                'error' => $e->getMessage(),
                'event_source_id' => $request->event_source_id
            ]);

            return response()->json([
                'message' => 'Error al procesar la solicitud de notificación',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        $notifications = \App\Models\Notification::orderByDesc('created_at')->get();

        return response()->json($notifications);
    }

    private function processNotification(Notification $notification, array $templateData, bool $async)
    {
        if ($async) {
            SendNotificationJob::dispatch($notification, $templateData);
            return [
                'message' => 'Solicitud de notificación recibida y encolada.',
                'tracking_id' => $notification->tracking_id
            ];
        }

        // Synchronous processing
        try {
            SendNotificationJob::dispatchSync($notification, $templateData);
            return [
                'message' => 'Notificación enviada exitosamente.',
                'tracking_id' => $notification->tracking_id
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function getDefaultSubject(string $eventType): string
    {
        return match ($eventType) {
            'solicitud_creada' => 'Nueva solicitud creada',
            'solicitud_estado_actualizado' => 'Actualización de estado de solicitud',
            default => 'Notificación del sistema'
        };
    }

    private function getTemplateName(string $eventType): string
    {
        return match ($eventType) {
            'solicitud_creada' => 'emails.solicitud-creada',
            'solicitud_estado_actualizado' => 'emails.solicitud-actualizada',
            default => 'emails.default'
        };
    }

    private function generateIdempotencyKey(SendNotificationRequest $request): string
    {
        // Create a unique key based on the request data
        $keyData = [
            $request->event_source_id,
            $request->event_type,
            $request->recipient_email,
            $request->subject_override,
            json_encode($request->template_data)
        ];
        
        return 'notification:' . md5(implode('|', $keyData));
    }
}
