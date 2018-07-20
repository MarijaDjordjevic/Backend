<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GameResource;
use App\Http\Controllers\Controller;
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

    public function createMove()
    {
        DB::table('moves')->insert([
            'game_id'   => $game_id,
            'player_id' => auth()->user()->id,
            'position'  => $position
        ]);
    }
}
