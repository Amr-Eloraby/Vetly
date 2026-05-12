<?php

namespace App\Http\Controllers\Api\Auth;

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
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $request->email],
                [
                    'otp' => Hash::make($otp),
                    'verified' => false,
                    'expires_at' => Carbon::now()->addMinutes(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully'
        ]);
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
            return response()->json([
                'message' => 'OTP not found'
            ], 400);
        }

        if (Carbon::now()->gt($record->expires_at)) {

            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'OTP expired'
            ], 400);
        }

        if (!Hash::check($request->otp, $record->otp)) {

            return response()->json([
                'message' => 'Invalid OTP'
            ], 400);
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->update([
                'verified' => true
            ]);

        return response()->json([
            'message' => 'OTP verified'
        ]);
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
            return response()->json([
                'message' => 'OTP verification required'
            ], 400);
        }

        if (Carbon::now()->gt($record->expires_at)) {

            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'message' => 'OTP expired'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'message' => 'Password reset successful'
        ]);
    }
}
