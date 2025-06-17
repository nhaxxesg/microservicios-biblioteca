<?php

namespace App\Repositories;

use App\Models\UserNotification;
use App\Contracts\Repositories\UserNotificationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserNotificationRepository implements UserNotificationRepositoryInterface
{
    /**
     * Obtener todas las notificaciones de un usuario
     *
     * @param int $userId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUserNotifications(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = UserNotification::where('user_id', $userId);
        
        // Aplicar filtros
        if (isset($filters['leida'])) {
            $query->where('leida', $filters['leida']);
        }
        
        if (isset($filters['fecha_inicio'])) {
            $query->whereDate('fecha', '>=', $filters['fecha_inicio']);
        }
        
        if (isset($filters['fecha_fin'])) {
            $query->whereDate('fecha', '<=', $filters['fecha_fin']);
        }
        
        // Ordenar por fecha descendente (más recientes primero)
        return $query->orderBy('fecha', 'desc')->paginate($perPage);
    }
    
    /**
     * Obtener una notificación por su ID
     *
     * @param int $id
     * @return UserNotification
     * @throws ModelNotFoundException
     */
    public function findById(int $id): UserNotification
    {
        return UserNotification::findOrFail($id);
    }
    
    /**
     * Crear una nueva notificación
     *
     * @param array $data
     * @return UserNotification
     */
    public function create(array $data): UserNotification
    {
        return UserNotification::create($data);
    }
    
    /**
     * Actualizar una notificación existente
     *
     * @param int $id
     * @param array $data
     * @return UserNotification
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): UserNotification
    {
        $notification = $this->findById($id);
        $notification->update($data);
        return $notification->fresh();
    }
    
    /**
     * Eliminar una notificación
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool) UserNotification::destroy($id);
    }
    
    /**
     * Marcar notificación como leída
     *
     * @param int $id
     * @return UserNotification
     */
    public function markAsRead(int $id): UserNotification
    {
        $notification = $this->findById($id);
        $notification->leida = true;
        $notification->save();
        return $notification;
    }
    
    /**
     * Contar notificaciones no leídas de un usuario
     *
     * @param int $userId
     * @return int
     */
    public function countUnread(int $userId): int
    {
        return UserNotification::where('user_id', $userId)
                            ->where('leida', false)
                            ->count();
    }
}
