<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\Interfaces\IRoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * @param IRoleService $roleService
     */
    public function __construct(
        protected IRoleService $roleService
    ) {}

    /**
     * Get all roles
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAll();
        return response()->json(['data' => $roles]);
    }

    /**
     * Create a new role
     */
    public function store(CreateRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->create($request->validated());
        return response()->json(['data' => $role], Response::HTTP_CREATED);
    }

    /**
     * Get a specific role
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getById($id);
        return response()->json(['data' => $role]);
    }

    /**
     * Update a role
     */
    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->update($id, $request->validated());
        return response()->json(['data' => $role]);
    }

    /**
     * Delete a role
     */
    public function destroy(int $id): JsonResponse
    {
        $this->roleService->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Assign role to user
     */
    public function assignRole(AssignRoleRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $this->roleService->assignRoleToUser($validated['user_id'], $validated['role_id']);
        return response()->json(['message' => 'Role assigned successfully']);
    }

    /**
     * Get user's role
     */
    public function getUserRole(int $userId): JsonResponse
    {
        $role = $this->roleService->getUserRole($userId);
        return response()->json(['data' => $role]);
    }

    /**
     * Remove role from user
     */
    public function removeUserRole(int $userId): JsonResponse
    {
        $this->roleService->removeUserRole($userId);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
