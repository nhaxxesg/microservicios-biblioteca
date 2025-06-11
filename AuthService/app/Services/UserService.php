<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserLocal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserService
{
    protected $baseUrl = 'http://127.0.0.1:8000';

    public function __construct()
    {
        $this->baseUrl = config('services.user_service.base_url');
    }

    public function getUserById($id)
    {
        $response = Http::get("{$this->baseUrl}/api/users/{$id}");
        return $response->json();
    }

    public function createUser(array $userData)
{
    $response = Http::post("http://127.0.0.1:8000/api/users", $userData);
    
    if ($response->failed()) {
        throw new \Exception('User creation failed: ' . $response->body());
    }
    
    return $response->json(); // Retorna array, no objeto
}

    public function validateUser(array $credentials)
    {
        $response = Http::post("{$this->baseUrl}/api/users/validate", $credentials);
        return $response->json();
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
