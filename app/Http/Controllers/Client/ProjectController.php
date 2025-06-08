<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

    class ProjectController extends Controller
    {
    use AuthorizesRequests;
    public function index(): View
    {
        $projects = Auth::user()->client->projects()
            ->with(['tasks', 'milestones', 'teamMembers.user'])
            ->latest()
            ->get();

        return view('client.projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load([
            'tasks',
            'milestones',
            'teamMembers.user',
            'documents',
            'messages' => function ($query) {
                $query->latest()->take(5);
            }
        ]);

        return view('client.projects.show', compact('project'));
    }

    public function documents(Project $project): View
    {
        $this->authorize('view', $project);

        $documents = $project->getMedia('documents');
        return view('client.projects.documents', compact('project', 'documents'));
    }

    public function timeline(Project $project): View
    {
        $this->authorize('view', $project);

        $milestones = $project->milestones()
            ->orderBy('due_date')
            ->get();

        return view('client.projects.timeline', compact('project', 'milestones'));
    }
}