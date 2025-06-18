<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\UserNotificationRepositoryInterface;
use App\Repositories\UserNotificationRepository;
use App\Contracts\Services\UserNotificationServiceInterface;
use App\Services\UserNotificationService;

class UserNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserNotificationRepositoryInterface::class, UserNotificationRepository::class);
        $this->app->bind(UserNotificationServiceInterface::class, UserNotificationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
