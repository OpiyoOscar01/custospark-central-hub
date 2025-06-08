<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalProjects = Project::count();
        $activeTasks = Task::whereIn('status', ['pending', 'in_progress'])->count();
        $teamMembers = TeamMember::distinct('user_id')->count();
        $totalClients = Client::count();

        $recentProjects = Project::with(['client'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingTasks = Task::with(['project', 'assignedUser'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'activeTasks',
            'teamMembers',
            'totalClients',
            'recentProjects',
            'upcomingTasks'
        ));
    }
}