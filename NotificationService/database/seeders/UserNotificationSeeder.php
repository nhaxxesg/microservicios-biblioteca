<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;

class UserNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la tabla antes de insertar nuevos datos
        DB::table('user_notifications')->truncate();
        
        // Crear notificaciones de ejemplo
        UserNotification::create([
            'user_id' => 1,
            'mensaje' => 'Bienvenido al sistema de biblioteca. Tu cuenta ha sido activada correctamente.',
            'fecha' => now(),
            'leida' => false
        ]);
        
        UserNotification::create([
            'user_id' => 1,
            'mensaje' => 'Tu solicitud de préstamo para el libro "Cien años de soledad" ha sido aprobada.',
            'fecha' => now()->subHours(2),
            'leida' => false
        ]);
        
        UserNotification::create([
            'user_id' => 2,
            'mensaje' => 'Recuerda que debes devolver el libro "El principito" antes del 30 de junio.',
            'fecha' => now()->subDays(1),
            'leida' => false
        ]);
        
        UserNotification::create([
            'user_id' => 2,
            'mensaje' => 'Tu solicitud de renovación para el libro "1984" ha sido rechazada.',
            'fecha' => now()->subDays(2),
            'leida' => true
        ]);
        
        UserNotification::create([
            'user_id' => 3,
            'mensaje' => 'Se te ha asignado una sanción por retraso en la devolución de libros.',
            'fecha' => now()->subWeek(),
            'leida' => false
        ]);
    }
}
