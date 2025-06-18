<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Dotenv\Dotenv;

// ✅ Cargar el archivo .env.shared desde el monorepo (uno arriba)
$sharedEnvPath = dirname(__DIR__) . '/.env.shared';
if (file_exists($sharedEnvPath)) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.shared');
    $dotenv->load(); // 🔁 Usa load(), no safeLoad()
    $dotenv->required(['JWT_SECRET']); // Opcional: asegura que existe

    dd($_ENV['JWT_SECRET'] ?? 'NO DEFINIDO');
}



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí registras middlewares personalizados
        $middleware->alias([
            'auth.jwt' => App\Http\Middleware\AuthJwtMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configurar manejo de excepciones si lo necesitas
    })
    ->create();
