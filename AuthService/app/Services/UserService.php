<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserService
{
    public function createUser(array $userData)
    {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
            'role_id' => $userData['role_id'] ?? null,
        ]);

        return $user;
    }   
    public function delete(User $user)
    {
        return $user->delete();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function getAll()
    {
        return User::with('role')->paginate(10);
    }
}