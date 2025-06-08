<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }
}