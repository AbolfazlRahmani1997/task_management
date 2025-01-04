<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);

        Log::info('User registered', ['user_id' => $user->id]);

        return $user;
    }

    public function login(array $credentials): ?string
    {

        if ($token = JWTAuth::attempt($credentials)) {
            Log::info('User logged in', ['user_id' => Auth::id()]);
            return $token;
        }


        return null;
    }

    public function me(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }
}
