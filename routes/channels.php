<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return $user->id === $id;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return $user->id === $id || $user->role === 'admin';
});
