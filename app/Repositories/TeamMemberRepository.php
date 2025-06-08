<?php

namespace App\Repositories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Collection;

class TeamMemberRepository
{
    public function getByProject(int $projectId): Collection
    {
        return TeamMember::where('project_id', $projectId)
            ->with(['user', 'project'])
            ->get();
    }

    public function create(array $data): TeamMember
    {
        return TeamMember::create($data);
    }

    public function update(TeamMember $teamMember, array $data): TeamMember
    {
        $teamMember->update($data);
        return $teamMember;
    }

    public function delete(TeamMember $teamMember): bool
    {
        return $teamMember->delete();
    }
}