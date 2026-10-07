<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Authors can delete their own replies; admins can delete any.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->is_admin;
    }

    /**
     * Anyone but the author can report a reply.
     */
    public function report(User $user, Comment $comment): bool
    {
        return $user->id !== $comment->user_id;
    }
}
