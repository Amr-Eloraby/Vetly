<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\EditProfileRequest;
use App\Services\ImageService;

class ProfileController extends Controller
{
    // Get user profile
    public function profile(Request $request)
    {        
        $user = $request->user();
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['image'] = ImageService::url($user->image);
        if ($user['google_id']){
            if ($user['is_fake_phone']==1){       
                $data['phone'] = null;
            }else{
                $data['phone'] = $user->phone;
            }
        }elseif($user['is_fake_phone']==1){
            $data['phone'] = null;
        }else{
            $data['phone'] = $user->phone;
        }
        
        return ApiResponse::sendResponse(200, 'User profile retrieved successfully', $data);
    }
    
    // Edit user profile
    public function editProfile(EditProfileRequest $request)
    {
        $user = $request->user();

        $request->validated();

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('phone')) {
            if($user['is_fake_phone']==1){
                $user->phone = $request->phone;
                $user->is_fake_phone = 0;
            }else{
                $user->phone = $request->phone;
            }
        }
        if ($request->hasFile('image')) {
            if ($user->image) {
                ImageService::delete($user->image);
            }
            $path = ImageService::upload($request->file('image'), 'users');
            $user->image = $path;
        }

        $user->save();

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['image'] = ImageService::url($user->image);
        $data['phone'] = $user->phone;

        return ApiResponse::sendResponse(200, 'Profile updated successfully', $data);
    }
}
