<?php

namespace App\Services;

use App\Exceptions\ModelNotFound\UserNameNotFoundException;
use App\Exceptions\ModelNotFound\UserNotFoundException;
use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(): Collection
    {
        return $this->userRepository->all();
    }

    public function getById(int $id): User|null
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            return $user;
        } else {
            throw new UserNotFoundException($id);
        }
    }

    public function getUserByUsername(string $name): User
    {
        $user = $this->userRepository->findUserByUsername($name);
        if($user){
            return $user;
        } else {
            throw new UserNameNotFoundException($name);
        }
    }

    public function updatedUser(int $id, UserUpdatedRequest $request): ?User
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            $user = $this->userRepository->update($user, $request);
            return $user;
        } else {
            throw new UserNotFoundException($id);
        }
    }

    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            $this->userRepository->delete($user);
        } else {
            throw new UserNotFoundException($id);
        }
    }
}
