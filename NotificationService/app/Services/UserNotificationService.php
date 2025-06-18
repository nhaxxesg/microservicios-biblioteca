<?php

namespace App\Services;

use App\Models\UserNotification;
use App\Contracts\Services\UserNotificationServiceInterface;
use App\Contracts\Repositories\UserNotificationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserNotificationService implements UserNotificationServiceInterface
{
    /**
     * @param UserNotificationRepositoryInterface $repository
     */
    public function __construct(
        protected UserNotificationRepositoryInterface $repository
    ) {
    }
    
    /**
     * Obtener notificaciones de un usuario
     *
     * @param int $userId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserNotifications(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getUserNotifications($userId, $filters, $perPage);
    }
    
    /**
     * Obtener una notificación por ID
     *
     * @param int $id
     * @return UserNotification
     */
    public function getNotificationById(int $id): UserNotification
    {
        return $this->repository->findById($id);
    }
    
    /**
     * Crear una nueva notificación
     *
     * @param array $data
     * @return UserNotification
     */
    public function createNotification(array $data): UserNotification
    {
        $notification = $this->repository->create($data);
        
        Log::info('Nueva notificación creada para usuario', [
            'notification_id' => $notification->id,
            'user_id' => $notification->user_id
        ]);
        
        return $notification;
    }
    
    /**
     * Actualizar una notificación
     *
     * @param int $id
     * @param array $data
     * @return UserNotification
     */
    public function updateNotification(int $id, array $data): UserNotification
    {
        $notification = $this->repository->update($id, $data);
        
        Log::info('Notificación actualizada', [
            'notification_id' => $id
        ]);
        
        return $notification;
    }
    
    /**
     * Eliminar una notificación
     *
     * @param int $id
     * @return bool
     */
    public function deleteNotification(int $id): bool
    {
        $result = $this->repository->delete($id);
        
        if ($result) {
            Log::info('Notificación eliminada', [
                'notification_id' => $id
            ]);
        }
        
        return $result;
    }
    
    /**
     * Marcar una notificación como leída
     *
     * @param int $id
     * @return UserNotification
     */
    public function markAsRead(int $id): UserNotification
    {
        $notification = $this->repository->markAsRead($id);
        
        Log::info('Notificación marcada como leída', [
            'notification_id' => $id,
            'user_id' => $notification->user_id
        ]);
        
        return $notification;
    }
    
    /**
     * Contar notificaciones no leídas
     *
     * @param int $userId
     * @return int
     */
    public function countUnreadNotifications(int $userId): int
    {
        return $this->repository->countUnread($userId);
    }
}
