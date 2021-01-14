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

        $oldPassword = $request->validated()['old_password'];
        $newPassword = $request->validated()['new_password'];

        if (Hash::check($oldPassword, $currentUser->password)) {
            $currentUser->password = $newPassword;
            $currentUser->save();
            return response('Password changed successfully');
        } else {
            return response('Old password does not match', 401);
        }
    }
}
