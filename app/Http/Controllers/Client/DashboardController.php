<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $client = Auth::user()->client;
        
        $projects = $client->projects()
            ->with(['tasks', 'milestones'])
            ->latest()
            ->get();

        $activeProjects = $projects->whereIn('status', ['pending', 'in_progress'])->count();
        $completedProjects = $projects->where('status', 'completed')->count();
        
        $upcomingMilestones = $client->projects()
            ->with('milestones')
            ->get()
            ->pluck('milestones')
            ->flatten()
            ->where('due_date', '>', now())
            ->where('status', 'pending')
            ->sortBy('due_date')
            ->take(5);

        $recentInvoices = $client->invoices()
            ->latest()
            ->take(5)
            ->get();

        $pendingFeedbacks = $client->feedbacks()
            ->whereIn('status', ['pending', 'in_review'])
            ->count();

        return view('client.dashboard', compact(
            'projects',
            'activeProjects',
            'completedProjects',
            'upcomingMilestones',
            'recentInvoices',
            'pendingFeedbacks'
        ));
    }
}