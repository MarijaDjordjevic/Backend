<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.7.18.
 * Time: 14.15
 */

namespace App\Services;

use App\Model\Game;
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
}
