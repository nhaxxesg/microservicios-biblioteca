<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Mail\DynamicEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification;
    protected $templateData;
    public $tries = 3;
    public $backoff = [60, 180, 300]; // Retry after 1 min, 3 min, 5 min

    public function __construct(Notification $notification, array $templateData)
    {
        $this->notification = $notification;
        $this->templateData = $templateData;
    }

    public function handle()
    {
        try {
            $this->notification->update([
                'status' => 'procesando',
                'attempts' => $this->notification->attempts + 1,
                'processed_at' => now()
            ]);

            // Log the attempt
            Log::info('Procesando notificación', [
                'tracking_id' => $this->notification->tracking_id,
                'attempt' => $this->notification->attempts
            ]);

            Mail::to($this->notification->recipient_email)
                ->send(new DynamicEmail(
                    $this->notification->template_used,
                    $this->notification->subject,
                    $this->templateData
                ));

            $this->notification->update([
                'status' => 'enviado',
                'sent_at' => now(),
                'error_details' => null
            ]);

            Log::info('Notificación enviada exitosamente', [
                'tracking_id' => $this->notification->tracking_id
            ]);
        } catch (\Exception $e) {
            $shouldRetry = $this->attempts() < $this->tries;
            $status = $shouldRetry ? 'fallido_reintentable' : 'fallido';
            
            $this->notification->update([
                'status' => $status,
                'error_details' => $e->getMessage()
            ]);

            Log::error('Error al enviar notificación', [
                'tracking_id' => $this->notification->tracking_id,
                'error' => $e->getMessage(),
                'will_retry' => $shouldRetry
            ]);

            if ($shouldRetry) {
                $delay = $this->backoff[$this->attempts() - 1] ?? 300;
                $this->release($delay);
            }

            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Fallo definitivo en el envío de notificación', [
            'tracking_id' => $this->notification->tracking_id,
            'error' => $exception->getMessage()
        ]);
    }
}
