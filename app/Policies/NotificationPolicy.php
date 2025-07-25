<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;

class NotificationPolicy
{
    /**
     * Determine whether the user can create notifications.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * (Opsional) Aturan lain, misal update/delete
     */
    public function update(User $user, Notification $notification): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Notification $notification): bool
    {
        return $user->role === 'admin';
    }
}
