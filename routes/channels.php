<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{to_user}', function ($user, $to_user) {
    return (int) $user->id === (int) $to_user;
});

Broadcast::channel('user.{toUserId}', function ($user, $toUserId) {
    return $user->id === $toUserId;
});

