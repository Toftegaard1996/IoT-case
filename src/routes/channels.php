<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// routes/channels.php
Broadcast::channel('testChannel', function () {
    return true; // or some condition to allow access to this channel
});
