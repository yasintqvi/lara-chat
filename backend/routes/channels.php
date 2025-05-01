<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('group.{groupId}', function ($user, $groupId) {
    return true;
    // return $user->groups->contains($groupId);
});
