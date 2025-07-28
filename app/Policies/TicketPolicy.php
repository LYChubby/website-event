<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    /**
     * Determine whether the user can create tickets.
     */
    public function create(User $user): bool
    {
        return $user->role === 'organizer';
    }

    /**
     * Determine whether the user can update the ticket.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->role === 'organizer' && $ticket->event->user_id === $user->user_id;
    }

    /**
     * Determine whether the user can delete the ticket.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === 'organizer' && $ticket->event->user_id === $user->user_id;
    }
}
