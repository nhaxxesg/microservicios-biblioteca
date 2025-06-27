<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Listar todos los usuarios con paginación
     * Opcionalmente filtrar por role_id
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = User::query();

            // Filtrar por role_id si se proporciona
            if ($request->has('role_id')) {
                $query->where('role_id', $request->role_id);
            }

            $users = $query->paginate(10);

            // Agregar información del rol en la respuesta
            $users->getCollection()->transform(function ($user) {
                $user->role_name = $this->getRoleName($user->role_id);
                return $user;
            });

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Usuarios obtenidos exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo usuario
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role_id' => 'nullable|integer|in:1,2' // 1 = usuario, 2 = admin
            ]);

            $user = $this->userService->createUser($validatedData);
            $user->role_name = $this->getRoleName($user->role_id);

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Usuario creado exitosamente'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener usuario por ID
     */
    public function show($id): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);
            $user->role_name = $this->getRoleName($user->role_id);
            
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Usuario encontrado'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }

    /**
     * Filtrar usuarios específicamente por role_id = 1 (usuarios)
     */
    public function getUsersByRoleOne(): JsonResponse
    {
        try {
            $users = User::where('role_id', 1)->paginate(10);

            $users->getCollection()->transform(function ($user) {
                $user->role_name = $this->getRoleName($user->role_id);
                return $user;
            });

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Usuarios con role_id = 1 (usuarios) obtenidos exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Filtrar usuarios por role_id = 2 (administradores)
     */
    public function getUsersByRoleTwo(): JsonResponse
    {
        try {
            $users = User::where('role_id', 2)->paginate(10);

            $users->getCollection()->transform(function ($user) {
                $user->role_name = $this->getRoleName($user->role_id);
                return $user;
            });

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'Usuarios con role_id = 2 (administradores) obtenidos exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8',
                'role_id' => 'sometimes|nullable|integer|in:1,2' // 1 = usuario, 2 = admin
            ]);

            // Si se proporciona password, encriptarlo
            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }

            $user->update($validatedData);
            $user->role_name = $this->getRoleName($user->role_id);

            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Usuario actualizado exitosamente'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);
            $this->userService->delete($user);

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener el nombre del rol basado en el role_id
     */
    private function getRoleName($roleId): string
    {
        switch ($roleId) {
            case 1:
                return 'usuario';
            case 2:
                return 'admin';
            default:
                return 'sin rol';
        }
    }
}
