<?php

namespace Tests\Feature;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PrestamosApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create(['is_admin' => false]);
    }

    public function test_admin_can_list_all_prestamos()
    {
        Sanctum::actingAs($this->admin);
        Prestamo::factory()->count(5)->create();

        $response = $this->getJson('/api/prestamos');

        $response->assertStatus(200)
                ->assertJsonCount(5, 'data');
    }

    public function test_admin_can_create_prestamo()
    {
        Sanctum::actingAs($this->admin);
        
        $prestamoData = [
            'libro_id' => 1,
            'user_id' => $this->user->id,
            'fecha_prestamo' => now()->toDateTimeString(),
            'fecha_devolucion_prevista' => now()->addDays(15)->toDateTimeString(),
            'estado' => Prestamo::ESTADOS()['ACTIVO']
        ];

        $response = $this->postJson('/api/prestamos', $prestamoData);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'libro_id' => 1,
                    'user_id' => $this->user->id,
                    'estado' => Prestamo::ESTADOS()['ACTIVO']
                ]);
    }

    public function test_user_can_view_own_prestamos()
    {
        Sanctum::actingAs($this->user);
        
        // Create prestamos for this user
        Prestamo::factory()->count(3)->create(['user_id' => $this->user->id]);
        // Create prestamos for another user
        Prestamo::factory()->count(2)->create();

        $response = $this->getJson("/api/prestamos/usuario/{$this->user->id}");

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_user_cannot_view_others_prestamos()
    {
        Sanctum::actingAs($this->user);
        $otherUser = User::factory()->create();
        
        $response = $this->getJson("/api/prestamos/usuario/{$otherUser->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_update_prestamo()
    {
        Sanctum::actingAs($this->admin);
        $prestamo = Prestamo::factory()->create();

        $response = $this->putJson("/api/prestamos/{$prestamo->id}", [
            'estado' => Prestamo::ESTADOS()['DEVUELTO'],
            'fecha_devolucion_real' => now()->toDateTimeString()
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'estado' => Prestamo::ESTADOS()['DEVUELTO']
                ]);
    }

    public function test_admin_can_delete_prestamo()
    {
        Sanctum::actingAs($this->admin);
        $prestamo = Prestamo::factory()->create();

        $response = $this->deleteJson("/api/prestamos/{$prestamo->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted($prestamo);
    }

    public function test_non_admin_cannot_create_prestamo()
    {
        Sanctum::actingAs($this->user);
        
        $prestamoData = [
            'libro_id' => 1,
            'user_id' => $this->user->id,
            'fecha_prestamo' => now()->toDateTimeString(),
            'fecha_devolucion_prevista' => now()->addDays(15)->toDateTimeString(),
            'estado' => Prestamo::ESTADOS()['ACTIVO']
        ];

        $response = $this->postJson('/api/prestamos', $prestamoData);

        $response->assertStatus(403);
    }

    public function test_validation_rules_for_creating_prestamo()
    {
        Sanctum::actingAs($this->admin);
        
        $response = $this->postJson('/api/prestamos', [
            'libro_id' => '',
            'user_id' => '',
            'fecha_prestamo' => 'invalid-date',
            'fecha_devolucion_prevista' => 'invalid-date',
            'estado' => 'invalid-estado'
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'libro_id',
                    'user_id',
                    'fecha_prestamo',
                    'fecha_devolucion_prevista',
                    'estado'
                ]);
    }
}
