<?php

namespace Tests\Feature;

use App\Models\Sancion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SancionApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_puede_crear_sancion()
    {
        $sancionData = [
            'usuario_id' => User::factory()->create()->id,
            'motivo' => 'Test motivo',
            'fecha_inicio' => now()->toDateTimeString(),
            'fecha_fin' => now()->addMonth()->toDateTimeString(),
            'estado' => 'activa'
        ];

        $response = $this->postJson('/api/sanciones', $sancionData);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'motivo' => 'Test motivo',
                    'estado' => 'activa'
                ]);
    }

    public function test_puede_obtener_sancion()
    {
        $sancion = Sancion::factory()->create();

        $response = $this->getJson("/api/sanciones/{$sancion->id}");

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => $sancion->id,
                    'motivo' => $sancion->motivo
                ]);
    }

    public function test_puede_actualizar_sancion()
    {
        $sancion = Sancion::factory()->create();
        $nuevosDatos = [
            'motivo' => 'Motivo actualizado',
            'estado' => 'cumplida'
        ];

        $response = $this->putJson("/api/sanciones/{$sancion->id}", $nuevosDatos);

        $response->assertStatus(200)
                ->assertJsonFragment($nuevosDatos);
    }

    public function test_puede_eliminar_sancion()
    {
        $sancion = Sancion::factory()->create();

        $response = $this->deleteJson("/api/sanciones/{$sancion->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted($sancion);
    }

    public function test_puede_listar_sanciones_por_usuario()
    {
        $usuario = User::factory()->create();
        $sanciones = Sancion::factory()->count(3)->create(['usuario_id' => $usuario->id]);

        $response = $this->getJson("/api/sanciones/usuario/{$usuario->id}");

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_valida_fechas_al_crear_sancion()
    {
        $sancionData = [
            'usuario_id' => User::factory()->create()->id,
            'motivo' => 'Test motivo',
            'fecha_inicio' => now()->addMonth()->toDateTimeString(),
            'fecha_fin' => now()->toDateTimeString(),
            'estado' => 'activa'
        ];

        $response = $this->postJson('/api/sanciones', $sancionData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['fecha_fin']);
    }
}
