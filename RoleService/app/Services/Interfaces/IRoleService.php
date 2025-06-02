<?php

namespace App\Services\Interfaces;

interface IRoleService
{
    /**
     * Create a new role
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Get a role by ID
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * Get all roles
     * @return mixed
     */
    public function getAll();

    /**
     * Update a role
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete a role
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Assign a role to a user
     * @param int $userId
     * @param int $roleId
     * @return mixed
     */
    public function assignRoleToUser(int $userId, int $roleId);

    /**
     * Get user's role
     * @param int $userId
     * @return mixed
     */
    public function getUserRole(int $userId);

    /**
     * Remove role from user
     * @param int $userId
     * @return mixed
     */
    public function removeUserRole(int $userId);
}
