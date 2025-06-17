<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserNotificationRequest;
use App\Http\Requests\UpdateUserNotificationRequest;
use App\Contracts\Services\UserNotificationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class UserNotificationController extends Controller
{
    /**
     * @param UserNotificationServiceInterface $notificationService
     */
    public function __construct(
        protected UserNotificationServiceInterface $notificationService
    ) {
    }

    /**
     * Listar notificaciones de un usuario con filtros opcionales.
     *
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    public function index(Request $request, int $userId): JsonResponse
    {
        $filters = $request->only([
            'leida',
            'fecha_inicio',
            'fecha_fin'
        ]);

        $perPage = $request->input('per_page', 15);
        
        $notifications = $this->notificationService->getUserNotifications($userId, $filters, $perPage);

        return response()->json($notifications);
    }

    /**
     * Obtener una notificación específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $notification = $this->notificationService->getNotificationById($id);
            
            return response()->json([
                'data' => $notification
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Notificación no encontrada',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Crear una nueva notificación.
     *
     * @param CreateUserNotificationRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserNotificationRequest $request): JsonResponse
    {
        try {
            $notification = $this->notificationService->createNotification($request->validated());

            return response()->json([
                'data' => $notification,
                'message' => 'Notificación creada exitosamente.'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Error al crear notificación', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'message' => 'Error al crear la notificación',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Actualizar una notificación existente.
     *
     * @param UpdateUserNotificationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserNotificationRequest $request, int $id): JsonResponse
    {
        try {
            $notification = $this->notificationService->updateNotification($id, $request->validated());

            return response()->json([
                'data' => $notification,
                'message' => 'Notificación actualizada exitosamente.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar notificación', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'message' => 'Error al actualizar la notificación',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Eliminar una notificación.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->notificationService->deleteNotification($id);

            if ($result) {
                return response()->json([
                    'message' => 'Notificación eliminada exitosamente.'
                ]);
            }
            
            return response()->json([
                'message' => 'No se pudo eliminar la notificación.'
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            Log::error('Error al eliminar notificación', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'message' => 'Error al eliminar la notificación',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Marcar una notificación como leída.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function markAsRead(int $id): JsonResponse
    {
        try {
            $notification = $this->notificationService->markAsRead($id);

            return response()->json([
                'data' => $notification,
                'message' => 'Notificación marcada como leída.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al marcar notificación como leída', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'message' => 'Error al marcar la notificación como leída',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Contar notificaciones no leídas de un usuario.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function countUnread(int $userId): JsonResponse
    {
        try {
            $count = $this->notificationService->countUnreadNotifications($userId);

            return response()->json([
                'data' => [
                    'user_id' => $userId,
                    'unread_count' => $count
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al contar notificaciones no leídas', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'message' => 'Error al contar notificaciones no leídas',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
