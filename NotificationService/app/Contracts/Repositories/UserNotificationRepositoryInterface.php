<?php

namespace App\Contracts\Repositories;

use App\Models\UserNotification;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserNotificationRepositoryInterface
{
    /**
     * Obtener todas las notificaciones de un usuario
     *
     * @param int $userId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserNotifications(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator;
    
    /**
     * Obtener una notificación por su ID
     *
     * @param int $id
     * @return UserNotification
     */
    public function findById(int $id): UserNotification;
    
    /**
     * Crear una nueva notificación
     *
     * @param array $data
     * @return UserNotification
     */
    public function create(array $data): UserNotification;
    
    /**
     * Actualizar una notificación existente
     *
     * @param int $id
     * @param array $data
     * @return UserNotification
     */
    public function update(int $id, array $data): UserNotification;
    
    /**
     * Eliminar una notificación
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * Marcar notificación como leída
     *
     * @param int $id
     * @return UserNotification
     */
    public function markAsRead(int $id): UserNotification;
    
    /**
     * Contar notificaciones no leídas de un usuario
     *
     * @param int $userId
     * @return int
     */
    public function countUnread(int $userId): int;
}
