<?php

namespace App\Services;

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
