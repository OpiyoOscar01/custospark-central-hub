<?php

namespace App\Policies;

use App\Models\TimeLog;
use App\Models\User;

class TimeLogPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TimeLog $timeLog): bool
    {
        return $user->isAdmin() || 
            $timeLog->task->project->teamMembers()->where('user_id', $user->id)->exists() ||
            $timeLog->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, TimeLog $timeLog): bool
    {
        return $user->isAdmin() || 
            $user->isProjectManager() || 
            $timeLog->user_id === $user->id;
    }

    public function delete(User $user, TimeLog $timeLog): bool
    {
        return $user->isAdmin() || 
            $user->isProjectManager() || 
            $timeLog->user_id === $user->id;
    }
}