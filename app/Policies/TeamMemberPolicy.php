<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TeamMember $teamMember): bool
    {
        return $user->isAdmin() || 
            $teamMember->project->teamMembers()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }

    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->isAdmin() || $user->isProjectManager();
    }
}