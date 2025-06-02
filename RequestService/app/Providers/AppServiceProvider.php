<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Repositories\RequestRepository;
use App\Contracts\Services\RequestServiceInterface;
use App\Services\RequestService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el repositorio
        $this->app->bind(RequestRepositoryInterface::class, RequestRepository::class);

        // Registrar el servicio
        $this->app->bind(RequestServiceInterface::class, RequestService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
