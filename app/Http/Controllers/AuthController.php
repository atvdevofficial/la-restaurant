<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $validatedEmail = $request->validated()['email'];
        $validatedPassword = $request->validated()['password'];

        $user = User::where('email', $validatedEmail)->first();

        if ($user) {
            if (Hash::check($validatedPassword, $user->password)) {
                $token = $user->createToken('LaravelPasswordGrantClient')->accessToken;
                return response([
                    'auth_token' => $token,
                    'role' => $user->role,
                    'user_id' => $user->id,
                    'profile_id' => $user->profile() ? $user->profile->id : null
                ]);
            }
        }

        return response('Invalid Credentials', 401);
    }

    public function logout()
    {
        $token = request()->user()->token();
        $token->revoke();
        return response(null, 204);
    }
}
