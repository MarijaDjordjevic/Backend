<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GameResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MoveResource;
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

    public function table($game_id)
    {
        $game = Game::find($game_id);
        if (isset($game->winner)) {
            return response()->json([
                'message' => 'Game Over',
                'winner'  => User::find($game->winner)->name
            ], 200);
        }

        if ($game->draw) {
            return response()->json([
                'message' => 'Draw',
            ], 200);
        }
        $moves = Move::where('game_id', $game_id)->get();

        return MoveResource::collection($moves);
    }
}
