<?php

namespace Database\Seeders;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create regular users
        $users = User::factory(5)->create();

        // Create some prestamos for each user
        $users->each(function ($user) {
            Prestamo::factory(3)->create(['user_id' => $user->id]);
            Prestamo::factory()->devuelto()->create(['user_id' => $user->id]);
            Prestamo::factory()->retrasado()->create(['user_id' => $user->id]);
        });
    }
}
