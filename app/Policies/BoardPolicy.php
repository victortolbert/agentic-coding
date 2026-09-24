<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;

/**
 * A board is private to its owner. The client's view goes through the share
 * token (the Public board row in docs/resources.md), never through this policy.
 */
class BoardPolicy
{
    public function view(User $user, Board $board): bool
    {
        return $board->user_id === $user->id;
    }

    public function update(User $user, Board $board): bool
    {
        return $board->user_id === $user->id;
    }

    public function delete(User $user, Board $board): bool
    {
        return $board->user_id === $user->id;
    }
}
