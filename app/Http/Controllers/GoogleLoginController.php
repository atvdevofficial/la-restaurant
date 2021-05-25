<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectGoogle($provider) {
        return Socialite::driver($provider)->redirect();
    }
    public function runCallback($provider) {
        try {
            $user = Socialite::driver($provider)->stateless()->user();

            $userExists = User::where('google_user_id', $user->id)->first();

            if($userExists) {
                Auth::login($userExists);
                return response(['User Exists!']);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_user_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                Auth::login($newUser);

                return response(['New User!', $newUser]);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
