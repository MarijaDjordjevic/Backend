<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MoveResource;
use App\Model\Game;
use App\Model\Move;
use App\Http\Controllers\Controller;

/**
 * Class MoveController
 * @package App\Http\Controllers\Api
 */
class MoveController extends Controller
{
    public function createMove($game_id, $position)
    {
        $move = new Move();
        $player_positions = $this->getPlayerPositions($game_id);

        if ($move->checkCombination($player_positions)) {
            return 'Game Over';
        }

        $all_positions = $this->getAllPositions($game_id);
        if ($all_positions == 9) {
            return 'Draw';
        }

        $playerX = Game::where('id', $game_id)->first()->player_x;
        $playerO = Game::where('id', $game_id)->first()->player_o;
        if (auth()->user()->id == $playerX) {
            $field_type = 'x';
        }
        if (auth()->user()->id == $playerO) {
            $field_type = 'o';
        }
        $move = new Move();
        $move->game_id = $game_id;
        $move->player_id = auth()->user()->id;
        $move->position = $position;
        $move->field_type = $field_type;
        $move->save();
        return new MoveResource($move);
    }

    public function getPlayerPositions($game_id)
    {
        $positions = Move::where('game_id', $game_id)
            ->where('player_id', auth()->user()->id)
            ->pluck('position')->toArray();
        return $positions;
    }

    public function getAllPositions($game_id)
    {
        return Move::where('game_id', $game_id)->count();
    }
}
