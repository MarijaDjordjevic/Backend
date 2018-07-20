<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllUsers()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * @param int $id
     * @return UserResource|JsonResponse
     */
    public function getUserById($id)
    {
        try {
            $user = User::findOrFail($id);

            return new UserResource($user);

        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Resource not found'], 404);
        }
    }

    /**
     * @param UserRegisterRequest $request
     * @return mixed
     */
    public function saveUser(UserRegisterRequest $request)
    {
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return $user;
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Failed to create a resource'], 417);
        }
    }
}
