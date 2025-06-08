<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilestoneRequest;
use App\Models\Milestone;
use App\Models\Project;
use App\Services\MilestoneService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class MilestoneController extends Controller
{
    use AuthorizesRequests;
    // Removed explicit property declaration as it is already promoted in the constructor

    public function __construct(private MilestoneService $milestoneService)
    {
       $this->milestoneService = $milestoneService;
    }
    protected function booted(): void
    {

        $this->authorizeResource(Milestone::class, 'milestone');
     }

    public function show(Milestone $milestone): View
    {
       
        return view('milestones.index', compact('milestone'));
    }

    public function create(Project $project): View
    {   $projects = Project::all();
        return view('milestones.create', compact('projects'));
    }

    public function store(MilestoneRequest $request): RedirectResponse
    {
        $this->milestoneService->createMilestone($request->validated());
        return redirect()->route('projects.show', $request->project_id)->with('success', 'Milestone created successfully.');
    }

    public function edit(Milestone $milestone): View
    {
        $milestone = Milestone::findOrFail($milestone->id);
        $projects = Project::all();
        return view('milestones.edit', compact('milestone', 'projects'));
    }

    public function update(MilestoneRequest $request, Milestone $milestone): RedirectResponse
    {
        $this->milestoneService->updateMilestone($milestone, $request->validated());
        return redirect()->route('projects.show', $milestone->project_id)->with('success', 'Milestone updated successfully.');
    }

    public function destroy(Milestone $milestone): RedirectResponse
    {
        $projectId = $milestone->project_id;
        $this->milestoneService->deleteMilestone($milestone);
        return redirect()->route('projects.show', $projectId)->with('success', 'Milestone deleted successfully.');
    }
}