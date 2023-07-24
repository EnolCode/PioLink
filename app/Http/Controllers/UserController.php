<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFound\UserNameNotFoundException;
use App\Exceptions\ModelNotFound\UserNotFoundException;
use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function findUserById(int $id): JsonResponse
    {
        $user = $this->userService->getById($id);
        return response()->json($user, 200);
    }

    public function findUserByUsername(string $name): JsonResponse
    {
        $user = $this->userService->getUserByUsername($name);
        return response()->json($user, 200);
    }

    public function findAllUsers(): Collection
    {
        return $this->userService->getAll();
    }

    public function updatedUser(int $id, UserUpdatedRequest $request): User
    {
        return $this->userService->updatedUser($id,$request);
    }

    public function deleteUser(int $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' =>'User with id '.$id .' deleted successfully.'], 200);
    }
}
