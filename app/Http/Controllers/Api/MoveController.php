<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MoveResource;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Services\MoveService;

/**
 * Class MoveController
 * @package App\Http\Controllers\Api
 */
class MoveController extends Controller
{
    /**
     * @param int $game_id
     * @param int $position
     * @return MoveResource|\Illuminate\Http\JsonResponse
     */
    public function createMove($game_id, $position)
    {
        $move = $this->moveService()->createMove($game_id, $position);

        if (MoveService::checkWinner($game_id)) {
            return response()->json([
                'message' => 'Game Over',
                'winner'  => User::find(auth()->user()->id)->name
            ], 200);
        }

        if (MoveService::checkDraw($game_id)) {
            return response()->json([
                'message' => 'Draw',
            ], 200);
        }

        return new MoveResource($move);
    }
}
