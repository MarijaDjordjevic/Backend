<?php

namespace App\Http\Controllers\Api;

use App\Events\ChallengeEvent;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\GameResource;
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
    public function getAppliedUsers()
    {
        $users = User::where('applied', 1)->where('id', '!=', auth()->user()->id)->get();

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

    public function setChallenge($challenged_id)
    {
        $user = auth()->user();
        $user->challenged()->attach($challenged_id);
        broadcast(new ChallengeEvent($user, $challenged_id));
        return $user->challenged()->where('challenged_id', $challenged_id)->first();
    }

    public function getChallengers()
    {
        $user = User::find(auth()->user()->id);
        return $user->challengers()->where('accepted', false)->get();
    }

    public function acceptChallenge($challenger_id)
    {
        $user = User::find(auth()->user()->id);
        $user->challengers()->updateExistingPivot($challenger_id, ['accepted' => true]);

        try {
            $game = $this->gameService()->createGame($challenger_id);

            return new GameResource($game);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Failed to create  resource'], 417);
        }
    }

    public function rejectChallenge($challenger_id)
    {
        $user = User::find(auth()->user()->id);
        $user->challengers()->detach($challenger_id);

        return 'rejected';
    }
}
