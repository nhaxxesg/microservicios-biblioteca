<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserLocal;
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
}

class UserServiceLocal
{
    public function create(array $data)
    {
        return UserLocal::create([
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

    public function delete(UserLocal $user)
    {
        return $user->delete();
    }

    public function findById($id)
    {
        return UserLocal::findOrFail($id);
    }

    public function getAll()
    {
        return UserLocal::with('role')->paginate(10);
    }
}
