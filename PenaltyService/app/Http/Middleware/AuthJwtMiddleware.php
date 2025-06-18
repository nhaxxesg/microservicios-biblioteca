<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Response;

class AuthJwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $secretKey = config('jwt.secret');

            if (empty($secretKey)) {
                throw new \Exception('La clave JWT_SECRET no está definida en el entorno.');
            }

            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            $request->attributes->add(['jwt_user' => (array) $decoded]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token inválido: ' . $e->getMessage()], 401);
        }
    }
}
