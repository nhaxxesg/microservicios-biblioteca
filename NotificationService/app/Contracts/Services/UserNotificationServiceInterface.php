<?php

namespace App\Contracts\Services;

use App\Models\UserNotification;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserNotificationServiceInterface
{
    /**
     * Obtener notificaciones de un usuario
     *
     * @param int $userId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserNotifications(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator;
    
    /**
     * Obtener una notificación por ID
     *
     * @param int $id
     * @return UserNotification
     */
    public function getNotificationById(int $id): UserNotification;
    
    /**
     * Crear una nueva notificación
     *
     * @param array $data
     * @return UserNotification
     */
    public function createNotification(array $data): UserNotification;
    
    /**
     * Actualizar una notificación
     *
     * @param int $id
     * @param array $data
     * @return UserNotification
     */
    public function updateNotification(int $id, array $data): UserNotification;
    
    /**
     * Eliminar una notificación
     *
     * @param int $id
     * @return bool
     */
    public function deleteNotification(int $id): bool;
    
    /**
     * Marcar una notificación como leída
     *
     * @param int $id
     * @return UserNotification
     */
    public function markAsRead(int $id): UserNotification;
    
    /**
     * Contar notificaciones no leídas
     *
     * @param int $userId
     * @return int
     */
    public function countUnreadNotifications(int $userId): int;
}
