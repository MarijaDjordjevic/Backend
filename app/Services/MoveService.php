<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.7.18.
 * Time: 16.16
 */

namespace App\Services;


use App\Events\GameOverEvent;
use App\Model\Game;
use App\Model\Move;

/**
 * Class MoveService
 * @package App\Services
 */
class MoveService
{
    /**
     * @param int $game_id
     * @param int $position
     * @return Move
     */
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

    /**
     * @param int $game_id
     * @return mixed
     */
    public function getPlayerPositions($game_id)
    {
        $positions = Move::where('game_id', $game_id)
            ->where('player_id', auth()->user()->id)
            ->pluck('position')->toArray();
        return $positions;
    }

    /**
     * @param int $game_id
     * @return mixed
     */
    public function getNumOfAllPositions($game_id)
    {
        return Move::where('game_id', $game_id)->count();
    }

    /**
     * @param int $game_id
     * @return mixed
     */
    public function getAllPositions($game_id)
    {
        return Move::where('game_id', $game_id)->pluck('position')->toArray();
    }

    /**
     * @param int $game_id
     * @return bool
     */
    public function checkWinner($game_id)
    {
        $player_positions = $this->getPlayerPositions($game_id);
        if (!Move::checkCombination($player_positions)) {
            return false;
        }
        $game = Game::find($game_id);
        $game->winner = auth()->user()->id;
        $game->save();
        //broadcast(new GameOverEvent($game));
        return $game;
    }

    /**
     * @param int $game_id
     * @return bool
     */
    public function checkDraw($game_id)
    {
        $all_positions = $this->getNumOfAllPositions($game_id);
        if ($all_positions != 9) {
            return false;
        }
        $game = Game::find($game_id);
        $game->draw = true;
        $game->save();
        //broadcast(new GameOverEvent($game));
        return $game;
    }

    /**
     * @param int $game_id
     * @return string
     */
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
