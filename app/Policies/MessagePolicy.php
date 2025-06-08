<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Message $message): bool
    {
        if ($message->project_id) {
            return $user->isAdmin() || 
                $message->project->teamMembers()->where('user_id', $user->id)->exists();
        }

        return $user->isAdmin() || 
            $message->task->project->teamMembers()->where('user_id', $user->id)->exists() ||
            $message->task->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Message $message): bool
    {
        return $user->isAdmin() || $message->user_id === $user->id;
    }

    public function delete(User $user, Message $message): bool
    {
        return $user->isAdmin() || $message->user_id === $user->id;
    }
}