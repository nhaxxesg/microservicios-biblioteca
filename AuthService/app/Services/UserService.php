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

class UserServiceLocal
{
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
        ]);
    }

    public function update(User $user, array $data)
    {
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
        ]);

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
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
