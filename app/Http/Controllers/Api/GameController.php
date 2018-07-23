<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GameResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MoveResource;
use App\Model\Game;
use App\Model\Move;
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

    public function createMove($game_id, $position)
    {
        DB::table('moves')->insert([
            'game_id'   => $game_id,
            'player_id' => auth()->user()->id,
            'position'  => $position
        ]);
        $data = [
            'game_id'   => $game_id,
            'player_id' => auth()->user()->id,
            'position'  => $position
        ];
        return response()->json($data);
    }

    public function table($game_id)
    {
//        $playerX = Game::where('id', $game_id)->first()->player_x;
//        $playerO = Game::where('id', $game_id)->first()->player_o;
//        $x = DB::table('moves')
//            ->where('game_id', $game_id)
//            ->where('player_id', $playerX)
//            ->select('position')
//            ->get();
//        $o = DB::table('moves')
//            ->where('game_id', $game_id)
//            ->where('player_id', $playerO)
//            ->select('position')
//            ->get();
//
//        return response()->json(['x' => $x, 'o' => $o]);
        $moves = Move::where('game_id', $game_id)->get();
        return MoveResource::collection($moves);
    }
}
