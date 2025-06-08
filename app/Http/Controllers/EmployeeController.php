<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Project;
use App\Models\Task;
use App\Models\TimeLog;
use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Illuminate\View\View;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    use AuthorizesRequests;
    // Removed the undefined AuthorizesResources trait

    public function __construct(private BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }
    protected function booted(): void
    {
        $this->authorizeResource(Task::class, 'task');
        $this->authorizeResource(Project::class, 'project');
        $this->authorizeResource(TimeLog::class, 'timeLog');
    }


public function dashboard(): View
{
    $userId = Auth::id();
    $now = Carbon::now();

    // Fetch active apps excluding Custospark, eager load plans (free, trial, paid)
    $apps = App::where('status', 'active')
        ->where('slug', '!=', 'custospark')
        ->with('plans')
        ->get();

    // Get user's active/trial subscriptions that are valid (not expired)
    $subscriptions = Subscription::where('user_id', $userId)
        ->whereIn('status', ['active', 'trial'])
        ->where(function ($query) use ($now) {
            $query->where(function ($q) use ($now) {
                $q->where('status', 'trial')
                  ->where('trial_ends_at', '>', $now);
            })->orWhere(function ($q) use ($now) {
                $q->where('status', 'active')
                  ->where(function ($q2) use ($now) {
                      $q2->whereNull('ends_at')
                         ->orWhere('ends_at', '>', $now);
                  });
            });
        })
        ->with('plan')
        ->get()
        ->keyBy('app_id');

    // Optionally, load expired subscriptions too if you want to show "expired" state (not required)

    return view('employee.dashboard', compact('apps', 'subscriptions'));
}


    public function tasks(): View
    {
        $userId = Auth::user()->id;
        
        $tasks = Task::with(['project'])
            ->where('assigned_to', $userId)
            ->orderBy('due_date')
            ->get();

        return view('employee.tasks', compact('tasks'));
    }

    public function projects(): View
    {
        $userId = Auth::user()->id;
        
        $projects = Project::whereHas('tasks', function ($query) use ($userId) {
                $query->where('assigned_to', $userId);
            })
            ->with(['client'])
            ->withCount(['tasks as my_tasks_count' => function ($query) use ($userId) {
                $query->where('assigned_to', $userId);
            }])
            ->get();

        return view('employee.projects', compact('projects'));
    }

    public function timeLogs(): View
    {
        $userId = Auth::user()->id;
        $now = Carbon::now();
        
        // Weekly hours
        $weeklyHours = TimeLog::where('user_id', $userId)
            ->whereBetween('date_logged', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->sum('hours_worked');

        // Monthly hours
        $monthlyHours = TimeLog::where('user_id', $userId)
            ->whereBetween('date_logged', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->sum('hours_worked');

        // Average daily hours
        $averageDailyHours = TimeLog::where('user_id', $userId)
            ->whereBetween('date_logged', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->avg('hours_worked');

        // Most active project
        $mostActiveProject = TimeLog::where('user_id', $userId)
            ->with('task.project')
            ->get()
            ->groupBy('task.project.name')
            ->map(function ($logs) {
                return $logs->sum('hours_worked');
            })
            ->sortDesc()
            ->keys()
            ->first() ?? 'N/A';

        // Time logs
        $timeLogs = TimeLog::with(['task', 'task.project'])
            ->where('user_id', $userId)
            ->latest('date_logged')
            ->paginate(15);

        return view('employee.time-logs', compact(
            'weeklyHours',
            'monthlyHours',
            'averageDailyHours',
            'mostActiveProject',
            'timeLogs'
        ));
    }
}