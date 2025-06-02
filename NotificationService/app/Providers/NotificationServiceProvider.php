<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Listen for failed jobs
        Queue::failing(function (JobFailed $event) {
            if (str_contains($event->job->resolveName(), 'SendNotificationJob')) {
                Log::error('Fallo en el trabajo de notificación', [
                    'job' => $event->job->resolveName(),
                    'exception' => $event->exception->getMessage(),
                ]);
            }
        });
    }
}
