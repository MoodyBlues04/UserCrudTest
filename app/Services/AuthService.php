<?php

namespace App\Services;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function register(RegisterRequest $request): string
    {
        /** @var User $user */
        $user = $this->userRepository->createFromRequest($request);
        if (!$this->attemptAuth($request)) {
            throw new \LogicException('Cannot authorize');
        }
        return $user->makeApiToken();
    }

    public function login(LoginRequest $request): string
    {
        /** @var ?User $user */
        $user = $this->userRepository->firstBy(['name' => $request->name]);
        if (!$user || !$this->attemptAuth($request)) {
            throw new \InvalidArgumentException('Invalid credentials');
        }
        return $user->makeApiToken();
    }

    private function attemptAuth(Request $request): bool
    {
        return Auth::attempt($request->only(['name', 'password']));
    }
}
