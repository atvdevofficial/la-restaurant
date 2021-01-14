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

    public function verifyContactNumber(VerifyContactNumberRequest $request)
    {
        $contactNumber = $request->validated()['contact_number'];
        $verificationCode = rand(111111, 999999);
        $message = 'Your ' . env('APP_NAME', 'Template') . ' new customer verification code is ' . $verificationCode;

        $iTextMoResponse = $this->sendSMS($contactNumber, $message);

        if ($iTextMoResponse == '0') return response(['code' => $verificationCode]);
        else return response(['message' => 'Something Went Wrong'], 422);
    }

    public function sendCodeToContactNumber(ForgotPasswordRequest $request)
    {
        $contactNumber = $request->validated()['contact_number'];
        $verificationCode = rand(111111, 999999);
        $message = 'Your ' . env('APP_NAME', 'Template') . ' forgot password verification code is ' . $verificationCode;

        $iTextMoResponse = $this->sendSMS($contactNumber, $message);
        $customer = $this->customerRepository->showByContactNumber($contactNumber);
        $user = $this->userRepository->show($customer->user_id);
        $this->userRepository->update($user->id, ['code' => $verificationCode]);

        if ($iTextMoResponse == '0') return response(['code' => $verificationCode]);
        else return response(['message' => 'Something Went Wrong'], 422);
    }

    public function verifyForgotPasswordCode(VerifyCodeRequest $request)
    {
        $contactNumber = $request->validated()['contact_number'];
        $verificationCode = $request->validated()['code'];

        $customer = $this->customerRepository->showByContactNumber($contactNumber);
        $user = $this->userRepository->show($customer->user_id);

        if ($user->code == $verificationCode) return response(null);
        else return response(null, 401);
    }

    public function forgotPasswordChangePassword(ChangePasswordRequest $request)
    {
        $contactNumber = $request->validated()['contact_number'];
        $verificationCode = $request->validated()['code'];
        $newPassword = $request->validated()['password'];

        $customer = $this->customerRepository->showByContactNumber($contactNumber);
        $user = $this->userRepository->show($customer->user_id);

        if ($user->code == $verificationCode) {
            $this->userRepository->update($user->id, [
                'code' => null,
                'password' => $newPassword,
            ]);
            return response([
                'message' => 'Password Changed Successfully'
            ]);
        }
        else return response(null, 401);
    }
}
