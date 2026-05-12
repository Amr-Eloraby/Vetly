<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ApiResponse::sendResponse(404, 'User not found', null);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $request->email],
                [
                    'otp' => Hash::make($otp),
                    'verified' => false,
                    'expires_at' => Carbon::now()->addMinutes(1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return ApiResponse::sendResponse(200, 'OTP sent to email', null);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return ApiResponse::sendResponse(404, 'OTP not found', null);
        }

        if (Carbon::now()->gt($record->expires_at)) {

            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return ApiResponse::sendResponse(400, 'OTP expired', null);
        }

        if (!Hash::check($request->otp, $record->otp)) {

            return ApiResponse::sendResponse(400, 'Invalid OTP', null);
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->update([
                'verified' => true
            ]);

        return ApiResponse::sendResponse(200, 'OTP verified', null);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('verified', true)
            ->first();

        if (!$record) {
            return ApiResponse::sendResponse(404, 'OTP not verified', null);
        }

        if (Carbon::now()->gt($record->expires_at)) {

            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return ApiResponse::sendResponse(400, 'OTP expired', null);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return ApiResponse::sendResponse(200, 'Password reset successful', null);
    }
}
