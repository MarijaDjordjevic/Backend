<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GameResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MoveResource;
use App\Http\Resources\UserResource;
use App\Model\Game;
use App\Model\Move;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class GameController
 * @package App\Http\Controllers\Api
 */
class GameController extends Controller
{
    /**
     * @param int $user_id
     * @return GameResource|JsonResponse
     */
    public function createGame($user_id)
    {
        try {
            $game = $this->gameService()->createGame($user_id);

            return new GameResource($game);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => 'Failed to create  resource'], 417);
        }
    }

    /**
     * @param int $game_id
     * @return bool|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getTable($game_id)
    {
        if ($response = $this->gameService()->gameOver($game_id)) {
            return $response;
        }
        $moves = Move::where('game_id', $game_id)->get();

        return MoveResource::collection($moves);
    }

    /**
     * @return UserResource
     */
    public function applyToGame()
    {
        $user = User::find(auth()->user()->id);
        $user->applied = true;
        $user->save();

        return new UserResource($user);
    }

    /**
     * @return GameResource|JsonResponse
     */
    public function checkGameStatus()
    {
        $game = Game::where('active', 1)->where('player_o', (auth()->user()->id))->first();
        if ($game) {
            return new GameResource($game);
        }
        return response()->json(['message' => 'No active game'], 200);
    }
}
