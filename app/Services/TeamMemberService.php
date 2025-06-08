<?php

namespace App\Services;

use App\Models\TeamMember;
use App\Models\User;
use App\Repositories\TeamMemberRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TeamMemberService
{
    public function __construct(private TeamMemberRepository $teamMemberRepository)
    {
    }

    public function getByProject(int $projectId): Collection
    {
        return $this->teamMemberRepository->getByProject($projectId);
    }

    public function getAvailableUsers($projectId): Collection
    {
        return User::whereNotExists(function ($query) use ($projectId) {
            $query->select(DB::raw(1))
                  ->from('team_members')
                  ->whereColumn('team_members.user_id', 'users.id')
                  ->where('team_members.project_id', $projectId);
        })->get();
        
    }

    public function createTeamMember(array $data): TeamMember
    {
        return $this->teamMemberRepository->create($data);
    }

    public function updateTeamMember(TeamMember $teamMember, array $data): TeamMember
    {
        return $this->teamMemberRepository->update($teamMember, $data);
    }

    public function deleteTeamMember(TeamMember $teamMember): bool
    {
        return $this->teamMemberRepository->delete($teamMember);
    }
}