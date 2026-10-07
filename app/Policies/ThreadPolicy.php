<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;

class ThreadPolicy
{
    /**
     * Authors can edit their own thread unless it's locked.
     */
    public function update(User $user, Thread $thread): bool
    {
        return $user->id === $thread->user_id && ! $thread->isLocked();
    }

    /**
     * Only the author can mark (or unmark) an accepted answer, and not once locked.
     */
    public function acceptAnswer(User $user, Thread $thread): bool
    {
        return $user->id === $thread->user_id && ! $thread->isLocked();
    }

    /**
     * Authors can delete their own threads; admins can delete any.
     */
    public function delete(User $user, Thread $thread): bool
    {
        return $user->id === $thread->user_id || $user->is_admin;
    }

    public function reply(User $user, Thread $thread): bool
    {
        return ! $thread->isLocked();
    }

    public function vote(User $user, Thread $thread): bool
    {
        return ! $thread->isLocked();
    }

    public function lock(User $user, Thread $thread): bool
    {
        return $user->is_admin;
    }

    /**
     * Anyone but the author can report a thread.
     */
    public function report(User $user, Thread $thread): bool
    {
        return $user->id !== $thread->user_id;
    }
}
