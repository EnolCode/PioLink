<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register(Request $request)
    {
        $request->validate([
            // 'name' => 'string|min:4|max:15',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:8|max:16'
        ]);

        $user = new User($request->all());
        $user = $this->userRepository->save($user);

        Profile::create([
            'id' => $user->id,
            'user_id'=>$user->id
        ]);

        return response()->json([
            "message" => "Successfully registered"
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=> ['required', 'email'],
            'password'=> ['required']
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token" => $token], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response()->json([
                'message' => 'Creedentials invalids'
            ], 401);
        }
    }

    public function userProfile(Request $request)
    {
        return response()->json([
            'data' => auth()->user()
        ]);
    }

    public function logout()
    {
        $cookie = Cookie::forget('cookie_token');
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout succesfully'
        ],200)->withCookie($cookie);
    }

}
