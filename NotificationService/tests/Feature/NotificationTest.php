<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Notification;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendNotificationJob;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Mail::fake();
    }

    public function test_can_send_notification_async()
    {
        $payload = [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'test@example.com',
            'template_data' => [
                'nombre_usuario' => 'Juan Pérez',
                'id_solicitud_visible' => 'S-00123',
                'descripcion_solicitud' => 'Cien Años de Soledad',
                'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
            ],
            'send_async' => true
        ];

        $response = $this->postJson('/api/notifications/send', $payload);

        $response->assertStatus(202)
                 ->assertJsonStructure(['message', 'tracking_id']);

        Queue::assertPushed(SendNotificationJob::class);
        
        $this->assertDatabaseHas('log_notificaciones', [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'test@example.com',
            'status' => 'encolado'
        ]);
    }

    public function test_can_send_notification_sync()
    {
        $payload = [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'test@example.com',
            'template_data' => [
                'nombre_usuario' => 'Juan Pérez',
                'id_solicitud_visible' => 'S-00123',
                'descripcion_solicitud' => 'Cien Años de Soledad',
                'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
            ],
            'send_async' => false
        ];

        $response = $this->postJson('/api/notifications/send', $payload);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'tracking_id']);

        Queue::assertNothingPushed();
        
        $this->assertDatabaseHas('log_notificaciones', [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'test@example.com',
            'status' => 'enviado'
        ]);
    }

    public function test_handles_idempotency()
    {
        $payload = [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'test@example.com',
            'template_data' => [
                'nombre_usuario' => 'Juan Pérez',
                'id_solicitud_visible' => 'S-00123',
                'descripcion_solicitud' => 'Cien Años de Soledad',
                'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
            ]
        ];

        // First request
        $response1 = $this->postJson('/api/notifications/send', $payload);
        $response1->assertStatus(202);

        // Second request with same data
        $response2 = $this->postJson('/api/notifications/send', $payload);
        $response2->assertStatus(200);
        
        // Should have same tracking ID
        $this->assertEquals(
            $response1->json('tracking_id'),
            $response2->json('tracking_id')
        );

        // Should only have one record
        $this->assertEquals(1, Notification::count());
    }

    public function test_validates_required_fields()
    {
        $response = $this->postJson('/api/notifications/send', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'event_source_id',
                     'event_type',
                     'recipient_email',
                     'template_data'
                 ]);
    }

    public function test_validates_email_format()
    {
        $payload = [
            'event_source_id' => 'solicitud_123',
            'event_type' => 'solicitud_creada',
            'recipient_email' => 'invalid-email',
            'template_data' => [
                'nombre_usuario' => 'Juan Pérez',
                'id_solicitud_visible' => 'S-00123',
                'descripcion_solicitud' => 'Cien Años de Soledad',
                'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
            ]
        ];

        $response = $this->postJson('/api/notifications/send', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['recipient_email']);
    }
}
