<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Mail\DynamicEmail;
use Illuminate\Support\Facades\View;

class DynamicEmailTest extends TestCase
{
    public function test_dynamic_email_builds_correctly()
    {
        $templateView = 'emails.solicitud-creada';
        $subject = 'Test Subject';
        $templateData = [
            'nombre_usuario' => 'Juan Pérez',
            'id_solicitud_visible' => 'S-00123',
            'descripcion_solicitud' => 'Cien Años de Soledad',
            'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
        ];

        View::addLocation(base_path('resources/views'));

        $email = new DynamicEmail($templateView, $subject, $templateData);
        
        $rendered = $email->render();

        $this->assertStringContainsString('Juan Pérez', $rendered);
        $this->assertStringContainsString('S-00123', $rendered);
        $this->assertStringContainsString('Cien Años de Soledad', $rendered);
        $this->assertStringContainsString('https://misistema.com/solicitudes/123', $rendered);
        
        $this->assertEquals($subject, $email->subject);
        $this->assertNotEmpty($email->getTrackingId());
    }

    public function test_status_update_email_builds_correctly()
    {
        $templateView = 'emails.solicitud-actualizada';
        $subject = 'Actualización de Estado';
        $templateData = [
            'nombre_usuario' => 'Juan Pérez',
            'id_solicitud_visible' => 'S-00123',
            'descripcion_solicitud' => 'Cien Años de Soledad',
            'nuevo_estado' => 'Aprobado',
            'link_detalle_solicitud' => 'https://misistema.com/solicitudes/123'
        ];

        View::addLocation(base_path('resources/views'));

        $email = new DynamicEmail($templateView, $subject, $templateData);
        
        $rendered = $email->render();

        $this->assertStringContainsString('Juan Pérez', $rendered);
        $this->assertStringContainsString('S-00123', $rendered);
        $this->assertStringContainsString('Aprobado', $rendered);
        $this->assertStringContainsString('https://misistema.com/solicitudes/123', $rendered);
        
        $this->assertEquals($subject, $email->subject);
        $this->assertNotEmpty($email->getTrackingId());
    }
}
