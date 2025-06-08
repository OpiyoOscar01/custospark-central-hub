<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;

class ResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Resource $resource): bool
    {
        return $user->isAdmin() || 
            $resource->project->teamMembers()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function update(User $user, Resource $resource): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function delete(User $user, Resource $resource): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }
}