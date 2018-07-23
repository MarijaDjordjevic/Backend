<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.7.18.
 * Time: 16.16
 */

namespace App\Services;


use App\Model\Game;
use App\Model\Move;

class MoveService
{
    public function createMove($game_id, $position)
    {
        $move = new Move();
        $move->game_id = $game_id;
        $move->player_id = auth()->user()->id;
        $move->position = $position;
        $move->field_type = $this->getFieldType($game_id);
        $move->save();

        return $move;
    }

    public static function getPlayerPositions($game_id)
    {
        $positions = Move::where('game_id', $game_id)
            ->where('player_id', auth()->user()->id)
            ->pluck('position')->toArray();
        return $positions;
    }

    public static function getAllPositions($game_id)
    {
        return Move::where('game_id', $game_id)->count();
    }

    public static function checkWinner($game_id)
    {
        $player_positions = self::getPlayerPositions($game_id);
        if (!Move::checkCombination($player_positions)) {
            return false;
        }
        $game = Game::find($game_id);
        $game->winner = auth()->user()->id;
        $game->save();

        return true;
    }

    public static function checkDraw($game_id)
    {
        $all_positions = self::getAllPositions($game_id);
        if ($all_positions != 9) {
            return false;
        }
        $game = Game::find($game_id);
        $game->draw = true;
        $game->save();

        return true;
    }

    public function getFieldType($game_id)
    {
        $playerX = Game::where('id', $game_id)->first()->player_x;
        $playerO = Game::where('id', $game_id)->first()->player_o;
        if (auth()->user()->id == $playerX) {
            $field_type = 'x';
        }
        if (auth()->user()->id == $playerO) {
            $field_type = 'o';
        }

        return $field_type;
    }
}
