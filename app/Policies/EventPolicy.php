<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function approve(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function viewAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}
