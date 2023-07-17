<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNameNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
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
        $user = User::where('name', $name)->first();
        if($user){
            return response()->json($user, 200);
        }
        throw new UserNameNotFoundException($name);
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

    public function deleteUser(int $id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return response('User with id ' . $id . ' deleted successfully.', 200);
        } catch (ModelNotFoundException){
            throw new UserNotFoundException($id);
        }
    }
}
