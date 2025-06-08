<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;


class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private ProjectService $projectService)
    {
        // No more authorizeResource here!
    }

    protected function booted(): void
    {
        $this->authorizeResource(Project::class, 'project');
    }

    public function index(): View
    {
        $projects = $this->projectService->getAllProjects();
        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        $clients = $this->projectService->getClients();
        return view('projects.create', compact('clients'));
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $this->projectService->createProject($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project): View
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $clients = $this->projectService->getClients();
        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $this->projectService->updateProject($project, $request->validated());
        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->projectService->deleteProject($project);
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}