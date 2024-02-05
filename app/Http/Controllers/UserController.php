<?php

namespace App\Http\Controllers;

use App\Helpers\JWTHelper;
use App\Helpers\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email']
            ]);

            $otp = rand(100000, 999999);

            $user = User::updateOrCreate(
                ['email' => $request->email],
                ['email' => $request->email, 'otp' => $otp]
            );

            Mail::to($user->email)->queue(new OTPMail($otp));

            return ResponseHelper::make('success', null, '6 Digit OTP Code Has Been Sent To Your Email.');

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function loginVerify(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'otp' => ['required', 'digits:6']
            ]);

            $user = User::where([
                'email' => $request->email,
                'otp' => $request->otp,
            ])->first();

            if ($user === null)
                throw new Exception("Invalid OTP.");

            $user->otp = "0";
            $user->save();

            $token = JWTHelper::createToekn($user->id, $user->email);

            return ResponseHelper::make('success', compact('user', 'token'), 'Login Successful.')->cookie('token', $token, 60*24*30);

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function logout()
    {
        return ResponseHelper::make('success', null, 'You Have Been Logged Out.')->cookie('token', null, -1);
    }

}
