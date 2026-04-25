<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AdminProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{

    // Edit profile
    public function edit()
    {
        return view('dashboard.profile.profile');
    }

    public function update(AdminProfileRequest $request)
    {
        $user = User::where('is_admin', 1)->first();
        $request->validated();
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }
}
