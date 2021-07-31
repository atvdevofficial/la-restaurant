<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Change password of user
     */
    public function changePassword(ChangePasswordRequest $request) {
        $currentUser = Auth::user();
        $password = $request->validated()['password'];

        $currentUser->password = $password;
        $currentUser->save();

        return response('Password changed successfully');
    }
}
