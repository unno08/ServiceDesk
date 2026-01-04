<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAnyBuyer(User $user): bool
    {
        return !$user->is_admin;
    }

    public function viewAnySeller(User $user): bool
    {
        return !$user->is_admin;
    }

    public function viewAnyAdmin(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->id === $ticket->buyer_id || $user->id === $ticket->seller_id;
    }

    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    public function message(User $user, Ticket $ticket): bool
    {
        return !$user->is_admin
            && ($user->id === $ticket->buyer_id || $user->id === $ticket->seller_id);
    }

    public function close(User $user, Ticket $ticket): bool
    {
        return (bool) $user->is_admin;
    }
}