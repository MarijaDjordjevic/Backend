<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Model\User;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return UserResource
     */
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);

        return (new UserResource($user))->additional(['access_token' => $token]);
    }

    /**
     * @param UserLoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = JWTAuth::attempt($credentials);
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            return (new UserResource($user))->additional(['access_token' => $token]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['success' => 'Logged out successfully'], 200);
    }
}
