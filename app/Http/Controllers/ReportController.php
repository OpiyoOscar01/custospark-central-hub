<?php

namespace App\Http\Controllers;

use App\Exports\ProjectReportExport;
use App\Exports\TimeLogReportExport;
use App\Models\Project;
use App\Models\TimeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function projectBurndown(Project $project): View
    {
        $startDate = $project->start_date;
        $endDate = $project->end_date;
        $totalDays = $startDate->diffInDays($endDate);
        
        $burndownData = [];
        $idealBurndown = [];
        $currentDate = $startDate->copy();
        
        $totalTasks = $project->tasks()->count();
        $remainingTasks = $totalTasks;
        $idealTasksPerDay = $totalTasks / $totalDays;

        while ($currentDate <= $endDate) {
            $completedTasks = $project->tasks()
                ->where('status', 'completed')
                ->where('updated_at', '<=', $currentDate)
                ->count();
                
            $burndownData[] = [
                'date' => $currentDate->format('Y-m-d'),
                'remaining' => $totalTasks - $completedTasks
            ];
            
            $idealBurndown[] = [
                'date' => $currentDate->format('Y-m-d'),
                'remaining' => max(0, $totalTasks - ($idealTasksPerDay * $currentDate->diffInDays($startDate)))
            ];
            
            $currentDate->addDay();
        }

        return view('reports.burndown', compact('project', 'burndownData', 'idealBurndown'));
    }

    public function resourceUtilization(Request $request): View
    {
        $startDate = Carbon::parse($request->start_date ?? Carbon::now()->startOfMonth());
        $endDate = Carbon::parse($request->end_date ?? Carbon::now()->endOfMonth());

        $users = User::with(['timeLogs' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date_logged', [$startDate, $endDate]);
        }])->get();

        $utilization = $users->map(function ($user) use ($startDate, $endDate) {
            $workingDays = $startDate->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, $endDate);
            
            $expectedHours = $workingDays * 8;
            $actualHours = $user->timeLogs->sum('hours_worked');
            
            return [
                'user' => $user->name,
                'expected_hours' => $expectedHours,
                'actual_hours' => $actualHours,
                'utilization_rate' => $expectedHours > 0 ? ($actualHours / $expectedHours) * 100 : 0
            ];
        });

        return view('reports.resource-utilization', compact('utilization', 'startDate', 'endDate'));
    }

    public function costTracking(Project $project): View
    {
        $budgetData = [
            'total_budget' => $project->budget,
            'spent_amount' => $project->timeLogs()
                ->where('is_billable', true)
                ->sum(DB::raw('hours_worked * rate')),
            'remaining_budget' => $project->budget - $project->timeLogs()
                ->where('is_billable', true)
                ->sum(DB::raw('hours_worked * rate'))
        ];

        $monthlySpending = $project->timeLogs()
            ->where('is_billable', true)
            ->selectRaw('DATE_FORMAT(date_logged, "%Y-%m") as month, SUM(hours_worked * rate) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('reports.cost-tracking', compact('project', 'budgetData', 'monthlySpending'));
    }

    public function teamPerformance(): View
    {
        $users = User::with(['assignedTasks', 'timeLogs'])
            ->whereHas('assignedTasks')
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'total_tasks' => $user->assignedTasks->count(),
                    'completed_tasks' => $user->assignedTasks->where('status', 'completed')->count(),
                    'on_time_completion_rate' => $user->assignedTasks->where('status', 'completed')->count() > 0
                        ? ($user->assignedTasks->where('status', 'completed')->where('completed_at', '<=', 'due_date')->count() /
                           $user->assignedTasks->where('status', 'completed')->count()) * 100
                        : 0,
                    'average_task_duration' => $user->assignedTasks->where('status', 'completed')->avg('duration'),
                    'billable_hours' => $user->timeLogs->where('is_billable', true)->sum('hours_worked'),
                    'total_hours' => $user->timeLogs->sum('hours_worked')
                ];
            });

        return view('reports.team-performance', compact('users'));
    }

    public function exportProjectReport(Project $project, string $format)
    {
        return match($format) {
            'excel' => Excel::download(new ProjectReportExport($project), 'project-report.xlsx'),
            'pdf' => Excel::download(new ProjectReportExport($project), 'project-report.pdf'),
            default => redirect()->back()->with('error', 'Unsupported format'),
        };
    }

    public function exportTimeLogReport(Request $request, string $format)
    {
        $startDate = Carbon::parse($request->start_date ?? Carbon::now()->startOfMonth());
        $endDate = Carbon::parse($request->end_date ?? Carbon::now()->endOfMonth());

        return match($format) {
            'excel' => Excel::download(new TimeLogReportExport($startDate, $endDate), 'time-log-report.xlsx'),
            'pdf' => Excel::download(new TimeLogReportExport($startDate, $endDate), 'time-log-report.pdf'),
            default => redirect()->back()->with('error', 'Unsupported format'),
        };
    }
}