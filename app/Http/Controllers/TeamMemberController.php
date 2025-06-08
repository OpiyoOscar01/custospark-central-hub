<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMemberRequest;
use App\Models\Project;
use App\Models\TeamMember;
use App\Services\TeamMemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TeamMemberController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private TeamMemberService $teamMemberService)
    {
       
    }

    
    protected function booted(): void
    {
        $this->authorizeResource(TeamMember::class, 'project');
    }
    public function index(Project $project): View
    {
        $teamMembers = $this->teamMemberService->getByProject($project->id);
        return view('team-members.index', compact('teamMembers', 'project'));
    }

    public function create($projectId): View
    {
        $users = $this->teamMemberService->getAvailableUsers($projectId);
        $project = Project::findOrFail($projectId);
        return view('team-members.create', compact('project', 'users'));
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        $this->teamMemberService->createTeamMember($request->validated());
        return redirect()->route('projects.show', $request->project_id)->with('success', 'Team member added successfully.');
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('team-members.edit', compact('teamMember'));
    }

    public function update(TeamMemberRequest $request, TeamMember $teamMember): RedirectResponse
    {
        $this->teamMemberService->updateTeamMember($teamMember, $request->validated());
        return redirect()->route('projects.show', $teamMember->project_id)->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $projectId = $teamMember->project_id;
        $this->teamMemberService->deleteTeamMember($teamMember);
        return redirect()->route('projects.show', $projectId)->with('success', 'Team member removed successfully.');
    }
}