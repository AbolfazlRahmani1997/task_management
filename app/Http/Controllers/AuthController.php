<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Auth\LoginUserRequest;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->all());

        return response()->json(['user' => $user], 201);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->only(['email', 'password']));

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function me(): JsonResponse
    {
        $user = $this->authService->me();

        return response()->json(['user' => $user]);
    }
}
