<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
Broadcast::channel('lobby', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
Broadcast::channel('user.{id}', function ($user, $id) {
    //return $user->id === $id;
    return true;
});
Broadcast::channel('challenge.{id}', function ($user, $id) {
//    if (($user->id === User::find($id)->challenged()->where('challenged_id', $id)->first()->pivot->challenged_id) ||
//        ($user->id === User::find($id)->challengers()->where('challenger_id', $id)->first()->pivot->challenger_id)) {
//        return true;
//    }
    return true;
});
Broadcast::channel('game.{id}', function ($user, $id) {
    //return $user->id === Move::->where('player_id', $id)->first()->player_id;
    return true;
});
