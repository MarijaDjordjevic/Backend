<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MoveResource;
use App\Http\Controllers\Controller;
use App\Model\Move;
use App\Model\User;

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
        if ($response = $this->gameService()->gameOver($game_id)) {
            return $response;
        }

        if (in_array($position, $this->moveService()->getAllPositions($game_id))) {
            return response()->json([
                'message' => 'This field has already been taken',
            ], 200);
        }

        if (Move::where('game_id', $game_id)->latest()->value('player_id') == auth()->user()->id) {
            return response()->json([
                'message' => 'It\'s not your turn, you have already made a move',
            ], 200);
        }

        $move = $this->moveService()->createMove($game_id, $position);
        if ($this->moveService()->checkWinner($game_id)) {
            return response()->json([
                'message' => 'Game Over',
                'winner'  => User::find(auth()->user()->id)->name
            ], 200);
        }
        if ($this->moveService()->checkDraw($game_id)) {
            return response()->json([
                'message' => 'Draw',
            ], 200);
        }

        return new MoveResource($move);
    }
}
