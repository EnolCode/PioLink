<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
class UserController extends Controller
{
    public function findUserById(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($id);
        }
    }

    public function findUserByUsername(string $name): JsonResponse
    {
        try{
            $user = User::where('name', $name)->first();
            return response()->json($user,200);
        } catch(ModelNotFoundException $e) {
            return abort(404);
        }
    }

    public function findAllUsers(): JsonResponse
    {
        try{
           $users = User::all();
           return response()->json($users, 200);
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function updatedUser(int $id, UserUpdatedRequest $request): JsonResponse
    {
        try{
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email'=> $request->email
            ]);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($id);
        }
    }
}
