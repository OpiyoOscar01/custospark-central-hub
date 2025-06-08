<?php

namespace App\Policies;

use App\Models\Milestone;
use App\Models\User;

class MilestonePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Milestone $milestone): bool
    {
        return $user->isAdmin() || 
            $milestone->project->teamMembers()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function update(User $user, Milestone $milestone): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function delete(User $user, Milestone $milestone): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }
}