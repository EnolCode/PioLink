<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    // USER
    Route::get('user/id/{id}', [UserController::class, 'findUserById']);
    Route::get('user/email/{email}', [UserController::class, 'findUserByEmail']);
    Route::get('users', [UserController::class, 'findAllUsers']);
    Route::patch('user/{id}', [UserController::class, 'updatedUser']);
    Route::delete('user/{id}', [UserController::class, 'deleteUser']);
    // PROFILE
    Route::get('profile/{id}', [ProfileController::class, 'findProfileById']);
    Route::get('profiles', [ProfileController::class, 'findAllProfiles']);
    Route::patch('profile/{id}', [ProfileController::class, 'update']);
    Route::delete('profile/{id}', [ProfileController::class, 'delete']);
    // POST
    Route::get('post/{id}', [PostController::class, 'findPostById']);
    Route::get('posts', [PostController::class, 'getAll']);
    Route::patch('post/{id}', [PostController::class, 'update']);
    Route::post('posts', [PostController::class, 'save']);
    Route::delete('post/{id}', [PostController::class, 'delete']);
    // FILE STORAGE
    Route::post('upload-avatar', [ProfileController::class, 'uploadAvatarImage']);

});
