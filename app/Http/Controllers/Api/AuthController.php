<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'status' => 'error',
                'message' => 'These credentials do not match our records.'
            ], 404);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'status' => 'success',
            'token' => $token,
            'user' => $user,
            'message' => 'Login successfull.'
        ], 200);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'status' => 'success',
            'message' => 'Logout successfull.'
        ], 200);
    }
}
