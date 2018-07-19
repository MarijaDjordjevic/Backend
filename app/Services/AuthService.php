<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.7.18.
 * Time: 13.59
 */

namespace App\Services;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Model\User;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    /**
     * @param UserRegisterRequest $request
     * @return mixed
     */
    public function saveUser(UserRegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $user;
    }

    /**
     * @param UserLoginRequest $request
     * @return mixed
     */
    public function setToken(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        JWTAuth::setToken($token);

        return $token;
    }

    public function invalidateToken()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
