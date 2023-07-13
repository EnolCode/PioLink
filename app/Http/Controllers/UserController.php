<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
class UserController extends Controller
{
    public function findUser(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($id);
        }
    }
}
