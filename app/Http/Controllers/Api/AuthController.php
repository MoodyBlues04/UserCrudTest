<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends ApiController
{
    public function __construct(private readonly AuthService $authService)
    {
        $this->middleware('auth:sanctum')->only('logout');
        $this->middleware('guest')->only(['login', 'register']);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request);
        return $this->success('user registered', compact('token'));
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request);
        return $this->success('user logged in', compact('token'));
    }
}
