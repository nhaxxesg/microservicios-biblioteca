<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userService = $userService;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string']
        ]);
        
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return $this->respondWithToken($newToken);;
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => config('jwt.ttl') * 60,
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
{
    $credentials = $request->validated();

    try {
        // Crear usuario usando el servicio - sin encriptar la contraseña aquí
        $user = $this->userService->createUser([
            'name'     => $credentials['name'],
            'email'    => $credentials['email'],
            'password' => $credentials['password'], // Sin bcrypt, lo hará el servicio
            'role_id'  => $credentials['role_id'] ?? 1,
        ]);

        // Verificar si el servicio retornó un usuario válido
        if (!$user) {
            throw new \Exception('User service returned empty response');
        }
        
        $login_credentials = [
            'email'    => $credentials['email'],
            'password' => $credentials['password'], // contraseña sin encriptar para auth()->attempt()
        ];
        
        // Intentar autenticación
        if (!$token = auth('api')->attempt($login_credentials)) {
            Log::error('Falló autenticación después de registrar usuario: ' . $credentials['email']);
            return response()->json(['error' => 'Authentication failed after registration ' . $credentials['email']], Response::HTTP_UNAUTHORIZED);
        }
        
        Log::info('Usuario registrado y autenticado: ' . $credentials['email']);
        return $this->respondWithToken($token);

    } catch (\Exception $e) {
        Log::error('Error en registro: ' . $e->getMessage());
        return response()->json(['error' => 'User registration failed: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}