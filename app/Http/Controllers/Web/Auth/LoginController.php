<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.login');
    }

    // login in dashboard
    public function login(LoginRequest $request)
    {
       $validatedData = $request->validated();

        if (auth()->attempt($validatedData)) {
            if (auth()->user()->is_admin) {
                return redirect()->route('dashboard.index');
            }
            return redirect()->route('dashboard.login')->with('message-login','This account is not verified.');
        }
        return redirect()->route('dashboard.login')->with('message-login','Invalid credentials.');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login');
    }
}
