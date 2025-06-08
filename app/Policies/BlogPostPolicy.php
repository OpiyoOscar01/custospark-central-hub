<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, BlogPost $post): bool
    {
        return $user->id === $post->author_id || $user->hasRole('admin');
    }

    public function delete(User $user, BlogPost $post): bool
    {
        return $user->id === $post->author_id || $user->hasRole('admin');
    }

    public function publish(User $user, BlogPost $post): bool
    {
        return $user->id === $post->author_id || $user->hasRole('admin');
    }
}
