<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

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
}
