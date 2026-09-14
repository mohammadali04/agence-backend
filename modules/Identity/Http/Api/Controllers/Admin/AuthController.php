<?php

namespace Modules\Identity\Http\Api\Controllers\Admin;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Modules\Identity\Http\Resources\UserResource;
use Modules\Identity\Models\User;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

//use Laravel\Passport\Http\Controllers\AccessTokenController;

class AuthController extends BaseResponderController
{
    public function users()
    {
        $users = User::all();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if($validated->fails()){
            return $this->sendError('Validation Error.', $validated->errors(),422);
        }

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken('auth_token')->accessToken;
        return $this->sendResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'User registered successfully.')
            ->withCookie(
                cookie(
                    'auth_token', $token,
                    60 * 24, null,
                    null,
                    false,
                    true,
                    false,
                    'Lax'
                ));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendResponse([], 'User not found');
        }
        if (!auth()->attempt($validated)) {
            return $this->sendResponse('Invalid credentials', 'ایمیل یا پسورد اشتباه است', 401);
        }
        $token = $user->createToken('auth_token')->accessToken;
        return $this->sendResponse([
            'user' => new UserResource($user),
            'token' => $token
        ], 'user logged in successfully')
            ->withCookie(
                cookie(
                    'auth_token', $token,
                    60 * 24, null,
                    null,
                    false,
                    true,
                    false,
                    'Lax'
                ));
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'Logout successfully.')
            ->withCookie(cookie()->forget('auth_token'));
    }

    public function user(Request $request)
    {
        $user = User::find($request->id);
        return $this->sendResponse(new UserResource($user), 'User found');
    }
    public function delete(int $id){
        User::findOrFail($id)->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }


//    private function issueToken(string $email, string $password): array
//    {
//        // ساختن یه Symfony Request
//        $symfonyRequest = new SymfonyRequest(
//            [], // GET params
//            [   // POST params
//                'grant_type' => 'password',
//                'client_id' => config('passport.password_client_id'),
//                'client_secret' => config('passport.password_client_secret'),
//                'username' => $email,
//                'password' => $password,
//                'scope' => '',
//            ],
//            [], // attributes
//            [], // cookies
//            [], // files
//            ['CONTENT_TYPE' => 'application/x-www-form-urlencoded'], // server
//            http_build_query([
//                'grant_type' => 'password',
//                'client_id' => config('passport.password_client_id'),
//                'client_secret' => config('passport.password_client_secret'),
//                'username' => $email,
//                'password' => $password,
//                'scope' => '',
//            ]) // content
//        );
//
//        // تبدیل به PSR-7
//        $request = \Laravel\Passport\Passport::serverRequestHandlers()
//            ? app(\Nyholm\Psr7\Factory\Psr17Factory::class)->createServerRequest(
//                'POST',
//                '/oauth/token',
//                $symfonyRequest->server->all()
//            )
//            : null;
//
//        // راه ساده‌تر: استفاده از HttpKernel
//        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
//        $laravelRequest = \Illuminate\Http\Request::createFrom($symfonyRequest);
//        $response = $kernel->handle($laravelRequest);
//
//        return json_decode($response->getContent(), true);
//    }


//    public function refresh(Request $request)
//    {
//        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
//            'grant_type' => 'refresh_token',
//            'refresh_token' => $request->refresh_token,
//            'client_id' => config('passport.password_client_id'),
//            'client_secret' => config('passport.password_client_secret'),
//            'scope' => '',
//        ]);
//
//        if ($response->failed()) {
//            return $this->sendError('Refresh failed', $response->json(), 401);
//        }
//
//        return $this->sendResponse($response->json(), 'Refresh token successfully.');
//    }


}
