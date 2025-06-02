<?php

namespace App\Services\Implementations;

use App\Models\Role;
use App\Models\User;
use App\Services\Interfaces\IRoleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleService implements IRoleService
{
    /**
     * @param Role $role
     */
    public function __construct(
        protected Role $role
    ) {}

    /**
     * Create a new role
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        return $this->role->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * Get a role by ID
     * @param int $id
     * @return Role
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Role
    {
        return $this->role->findOrFail($id);
    }

    /**
     * Get all roles
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->role->all();
    }

    /**
     * Update a role
     * @param int $id
     * @param array $data
     * @return Role
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): Role
    {
        $role = $this->getById($id);
        $role->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? $role->description,
        ]);
        return $role->fresh();
    }

    /**
     * Delete a role
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function delete(int $id): bool
    {
        return $this->getById($id)->delete();
    }

    /**
     * Assign a role to a user
     * @param int $userId
     * @param int $roleId
     * @return void
     * @throws ModelNotFoundException
     */
    public function assignRoleToUser(int $userId, int $roleId): void
    {
        $user = User::findOrFail($userId);
        $role = $this->getById($roleId);
        
        // First remove any existing role
        $user->roles()->detach();
        
        // Assign new role
        $user->roles()->attach($role);
    }

    /**
     * Get user's role
     * @param int $userId
     * @return Role|null
     */
    public function getUserRole(int $userId): ?Role
    {
        $user = User::findOrFail($userId);
        return $user->roles()->first();
    }

    /**
     * Remove role from user
     * @param int $userId
     * @return void
     */
    public function removeUserRole(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach();
    }
}
