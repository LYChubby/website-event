<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    public function update(User $user, Event $event)
    {
        return $user->role === 'organizer' && $event->user_id === $user->user_id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->role === 'organizer' && $event->user_id === $user->user_id;
    }

    public function approve(User $user)
    {
        return $user->role === 'admin';
    }

    public function viewAdmin(User $user)
    {
        return $user->role === 'admin';
    }
}
