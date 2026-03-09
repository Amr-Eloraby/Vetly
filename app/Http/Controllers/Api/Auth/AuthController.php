<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        $data ['name'] = $user->name;
        $data ['email'] = $user->email;
        $data ['phone'] = $user->phone;
        $data ['token'] = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::sendResponse(201, 'User registered successfully', $data);    
    }

    // Login user 
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $data['name'] = $user->name;
            $data['token'] = $user->createToken('auth_token')->plainTextToken;
            return ApiResponse::sendResponse(200, 'User logged in successfully', $data);
        }
        return ApiResponse::sendResponse(401, 'Invalid email or password', null);
    }

    // Google Login
    public function googleLogin(Request $request)
    {
        $client = new Google_Client([
            'client_id' => env('GOOGLE_CLIENT_ID')
        ]);

        $payload = $client->verifyIdToken($request->id_token);

        if (!$payload) {
            return ApiResponse::sendResponse(401,'Invalid Google Token',);
        }

        $randomEgyptianPhone = '01' . rand(0, 1) . rand(0, 9) . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $user = User::updateOrCreate(
            ['email' => $payload['email']],
            [
                'name' => $payload['name'],
                'google_id' => $payload['sub'],
                'phone' => $payload['phone'] ?? "$randomEgyptianPhone",
                'password' => Hash::make(Str::random(16))
            ]
            
            
        ); 

        $data['email']=$user['email'];
        $data['name']=$user['name'];
        $data['token']=$user->createToken('api')->plainTextToken;

        return ApiResponse::sendResponse(200,'User logged in successfully by google',$data);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();   
        return ApiResponse::sendResponse(200, 'User logged out successfully', null);
    }        
}
