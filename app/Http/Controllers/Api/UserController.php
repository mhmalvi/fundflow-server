<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user_register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken($request->name)->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'status' => 201,
                'data' => [
                    'username' => $request->name,
                    'email' => $request->email,
                    'token' => $token,
                ],
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || Hash::check($user->password, $request->password)) {
            return response([
                'message' => 'Email or password not correct'
            ], 401);
        } else {
            $token = $user->createToken('mytoken')->plainTextToken;
            return response([
                'token' => $token,
                'message' => 'Login successful'
            ], 201);
        }
    }

    public function logout(Request $request)
    {
        $logout = auth('sanctum')->user()->tokens()->delete();
        if ($logout == 1) {
            return response()->json([
                'message' => 'logged out',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'token does not exist',
                'status' => 404
            ], 404);
        }
    }
}
