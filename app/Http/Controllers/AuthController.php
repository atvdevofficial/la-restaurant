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
    public function login (LoginRequest $request) {

        $validatedEmail = $request->validated()['email'];
        $validatedPassword = $request->validated()['password'];

        $user = User::where('email', $validatedEmail)->firstOrFail();

        if (Hash::check($validatedPassword, $user->password)) {
            $token = $user->createToken('LaravelPasswordGrantClient')->accessToken;
            return response($token);
        }

        return response('Invalid Credentials', 401);
    }

    public function logout () {
        $token = request()->user()->token();
        $token->revoke();
        return response(null, 204);
    }
}
