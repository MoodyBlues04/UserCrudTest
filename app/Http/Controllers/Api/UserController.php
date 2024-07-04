<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\User\CreateRequest;
use App\Http\Requests\Api\User\UpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAll();
        return $this->success('success', $users);
    }

    public function show(User $user): JsonResponse
    {
        return $this->success('success', $user->toArray());
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $user = $this->userRepository->createFromRequest($request);
        return $this->success('user created', $user->toArray());
    }

    public function update(User $user, UpdateRequest $request): JsonResponse
    {
        if (!$this->userRepository->updateFromRequest($request, $user)) {
            throw new \LogicException('Cannot update');
        }
        return $this->success('updated', $user->toArray());
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return $this->success('deleted');
    }
}
