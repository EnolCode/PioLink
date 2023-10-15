<?php

namespace App\Services;

use App\Exceptions\ModelNotFound\EmailNotFoundException;
use App\Exceptions\ModelNotFound\UserNotFoundException;
use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UserService implements BaseService
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

    public function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->findUserByEmail($email);
        if($user){
            return $user;
        } else {
            throw new EmailNotFoundException($email);
        }
    }

    public function update(int $id, UserUpdatedRequest $request): ?User
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            return $this->userRepository->update($user, $request);
        } else {
            throw new UserNotFoundException($id);
        }
    }

    public function delete(int $id): void
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            $this->userRepository->delete($user);
        } else {
            throw new UserNotFoundException($id);
        }
    }
}
