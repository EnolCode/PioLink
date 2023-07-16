<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::get('user/id/{id}', [UserController::class, 'findUserById']);
    Route::get('user/name/{name}', [UserController::class, 'findUserByUsername']);
    Route::get('users', [UserController::class, 'findAllUsers']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('user/{id}', [UserController::class, 'updatedUser']);
});
