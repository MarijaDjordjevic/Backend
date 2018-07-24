<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.7.18.
 * Time: 14.15
 */

namespace App\Services;

use App\Model\Game;
use App\Model\User;
use Illuminate\Http\JsonResponse;

/**
 * Class GameService
 * @package App\Services
 */
class GameService
{
    /**
     * @param int $user_id
     * @return Game|JsonResponse
     */
    public function createGame($user_id)
    {
        $game = new Game();
        $game->player_x = auth()->user()->id;
        $game->player_o = $user_id;
        $game->save();

        return $game;
    }

    /**
     * @param int $game_id
     * @return bool|JsonResponse
     */
    public function gameOver($game_id)
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

        return false;
    }
}
