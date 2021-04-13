<?php

namespace App\Http\Controllers;

use App\Http\Requests\Verification\ChangePasswordRequest;
use App\Http\Requests\Verification\ForgotPasswordRequest;
use App\Http\Requests\Verification\VerifyCodeRequest;
use App\Http\Requests\Verification\VerifyContactNumberRequest;
use App\Traits\ITextMo;

class VerificationController extends Controller
{
    use ITextMo;

    /**
     * Verify contact number
     *
     * @param  \App\Http\Requests\VerifyContactNumberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function verifyContactNumber(VerifyContactNumberRequest $request)
    {
        // $contactNumber = $request->validated()['contact_number'];
        // $verificationCode = rand(111111, 999999);
        // $message = 'Your ' . env('APP_NAME', 'Template') . ' new user verification code is ' . $verificationCode;

        // $iTextMoResponse = $this->sendSMS($contactNumber, $message);

        // if ($iTextMoResponse == '0') return response(['code' => $verificationCode]);
        // else return response(['message' => 'Something Went Wrong', 'code' => $iTextMoResponse], 500);
    }

    /**
     * Send generated code to contact number
     *
     * @param  \App\Http\Requests\ForgotPasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function sendCodeToContactNumber(ForgotPasswordRequest $request)
    {
        // $contactNumber = $request->validated()['contact_number'];
        // $verificationCode = rand(111111, 999999);
        // $message = 'Your ' . env('APP_NAME', 'Template') . ' forgot password user verification code is ' . $verificationCode;

        // $iTextMoResponse = $this->sendSMS($contactNumber, $message);

        // $rider = Rider::whereContactNumber($contactNumber);
        // $rider->user->update(['code' => $verificationCode]);

        // if ($iTextMoResponse == '0')
        //     return response(['code' => $verificationCode]);
        // else
        //     return response(['message' => 'Something Went Wrong', 'code' => $iTextMoResponse], 500);
    }

    /**
     * Verify code for change password request
     *
     * @param  \App\Http\Requests\VerifyCodeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function verifyForgotPasswordCode(VerifyCodeRequest $request)
    {
        // $contactNumber = $request->validated()['contact_number'];
        // $verificationCode = $request->validated()['code'];

        // $rider = Rider::whereContactNumber($contactNumber);
        // $riderUser = $rider->user;

        // if ($riderUser->code == $verificationCode)
        //     return response(['message' => 'Verification Code Match'], 200);
        // else
        //     return response(['message' => 'Verification Code Mismatch', 422]);
    }

    /**
     * Change password of forgot password
     *
     * @param  \App\Http\Requests\VerifyCodeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPasswordChangePassword(ChangePasswordRequest $request)
    {
        // $contactNumber = $request->validated()['contact_number'];
        // $verificationCode = $request->validated()['code'];
        // $newPassword = $request->validated()['password'];

        // $rider = Rider::whereContactNumber($contactNumber);
        // $riderUser = $rider->user;

        // if ($riderUser->code == $verificationCode) {
        //     $riderUser->update(['code' => null, 'password' => $newPassword]);
        //     return response(['message' => 'Password Changed Successfully']);
        // } else
        //     return response(null, 401);
    }
}
