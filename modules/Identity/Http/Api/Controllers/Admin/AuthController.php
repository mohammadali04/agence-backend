<?php

namespace Modules\Identity\Http\Api\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Identity\Models\User;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;

class AuthController extends BaseResponderController
{
    public function register(Request $request){
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $tokens = $this->issueToken($request->email, $request->password);
        return $this->sendResponse([
            'tokens' => $tokens,
            'user' => $user,
        ], 'Register successfully.');

    }
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return $this->sendResponse([], 'User not found');
        }
        if(!auth()->attempt($validated)){
            return $this->sendResponse('Invalid credentials','ایمیل یا پسورد اشتباه است',401);
        }
        $tokens = $this->issueToken($request->email, $request->password);
        return $this->sendResponse([
            'tokens' => $tokens,
            'user' => $user,
        ], 'Login successfully.');
    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'Logout successfully.');
    }
    public function user(Request $request){
        return $this->sendResponse(['user' => $request->user()], 'User found');
    }
    private function issueToken($email,$password){
        $response=Http::asForm()->post(config('app.url').'/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'email' => $email,
            'password' => $password,
            'scope' => '',
        ]);
        if($response->failed()){
            abort(401,'خطا در ارسال توکن');
        }
        return $response->json();
    }
    public function refresh(Request $request)
    {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => config('auth.passport_client_id'),
            'client_secret' => config('auth.passport_client_secret'),
            'scope' => '',
        ]);

//        return $response->json();
        return $this->sendResponse($response, 'Refresh token successfully.');
    }


}
