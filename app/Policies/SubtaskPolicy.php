<?php

namespace App\Policies;

use App\Models\Subtask;
use App\Models\User;

class SubtaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Subtask $subtask): bool
    {
        return $user->isAdmin() || 
            $subtask->task->project->teamMembers()->where('user_id', $user->id)->exists() ||
            $subtask->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function update(User $user, Subtask $subtask): bool
    {
        return $user->isAdmin() || 
            $user->isProjectManager() || 
            $subtask->assigned_to === $user->id;
    }

    public function delete(User $user, Subtask $subtask): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }
}