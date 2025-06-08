<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Milestone;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $currentView = $request->get('view', 'month');
        $currentDate = Carbon::parse($request->get('date', now()));
        $calendar = [];

        switch ($currentView) {
            case 'day':
                $calendar = $this->getDayView($currentDate);
                break;
            case 'week':
                $calendar = $this->getWeekView($currentDate);
                break;
            case 'month':
                $calendar = $this->getMonthView($currentDate);
                break;
            case 'year':
                $calendar = $this->getYearView($currentDate);
                break;
        }

        return view('calendar.index', compact('calendar', 'currentView', 'currentDate'));
    }

    private function getDayView(Carbon $date): array
    {
        $hours = [];
    
        // Step 1: Get the project IDs for tasks assigned to the current user
        $projectIds = Task::where('assigned_to', Auth::id())
            ->pluck('project_id')
            ->unique();
    
        // Generate hourly slots
        for ($hour = 0; $hour < 24; $hour++) {
            $time = Carbon::createFromTime($hour);
            $hourKey = $time->format('H:00');
    
            $hours[$hour] = [
                'time' => $time->format('H:i'),
                'items' => []
            ];
    
            // Step 2: Get tasks for this hour
            $tasks = Task::where('assigned_to', Auth::id())
                ->whereDate('due_date', $date->format('Y-m-d'))
                ->whereTime('due_date', '>=', $time->format('H:i:s'))
                ->whereTime('due_date', '<', $time->addHour()->format('H:i:s'))
                ->get()
                ->map(function ($task) {
                    return [
                        'type' => 'task',
                        'id' => $task->id,
                        'title' => $task->title,
                        'priority' => $task->priority,
                        'url' => route('tasks.show', $task)
                    ];
                });
    
            // Step 3: Get milestones for this hour (limited to user's task projects)
            $milestones = Milestone::whereIn('project_id', $projectIds)
                ->whereDate('due_date', $date->format('Y-m-d'))
                ->whereTime('due_date', '>=', $time->format('H:i:s'))
                ->whereTime('due_date', '<', $time->addHour()->format('H:i:s'))
                ->get()
                ->map(function ($milestone) {
                    return [
                        'type' => 'milestone',
                        'id' => $milestone->id,
                        'title' => $milestone->title,
                        'url' => route('projects.show', $milestone->project_id)
                    ];
                });
    
            // Step 4: Combine tasks and milestones
            $hours[$hour]['items'] = $tasks->concat($milestones)->toArray();
        }
    
        return [
            'hours' => $hours,
            'date' => $date
        ];
    }
    

    private function getWeekView(Carbon $date): array
    {
        $startDate = $date->copy()->startOfWeek();
        $endDate = $date->copy()->endOfWeek();
        $days = [];
    
        // Step 1: Get the project IDs for tasks assigned to the current user
        $projectIds = Task::where('assigned_to', Auth::id())
            ->pluck('project_id')
            ->unique();
    
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Y-m-d');
    
            // Step 2: Count user's tasks for the day
            $tasks = Task::where('assigned_to', Auth::id())
                ->whereDate('due_date', $dateKey)
                ->get()
                ->map(function ($task) {
                    return [
                        'type' => 'task',
                        'id' => $task->id,
                        'title' => $task->title,
                        'priority' => $task->priority,
                        'url' => route('tasks.show', $task)
                    ];
                });
    
            // Step 3: Count milestones for the user's task projects
            $milestones = Milestone::whereIn('project_id', $projectIds)
                ->whereDate('due_date', $dateKey)
                ->get()
                ->map(function ($milestone) {
                    return [
                        'type' => 'milestone',
                        'id' => $milestone->id,
                        'title' => $milestone->title,
                        'url' => route('projects.show', $milestone->project_id)
                    ];
                });
    
            // Step 4: Combine tasks and milestones
            $days[$dateKey] = [
                'date' => $currentDate->copy(),
                'isToday' => $currentDate->isToday(),
                'items' => $tasks->concat($milestones)->toArray()
            ];
    
            $currentDate->addDay();
        }
    
        return [
            'days' => $days,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
    

    private function getMonthView(Carbon $date): array
    {
        $startDate = $date->copy()->startOfMonth()->startOfWeek();
        $endDate = $date->copy()->endOfMonth()->endOfWeek();
        $weeks = [];
    
        // Step 1: Get the project_ids for tasks assigned to the current user
        $projectIds = Task::where('assigned_to', Auth::id())
            ->pluck('project_id')
            ->unique();
    
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateKey = $currentDate->format('Y-m-d');
    
                // Step 2: Count user's tasks for the day
                $tasks = Task::where('assigned_to', Auth::id())
                    ->whereDate('due_date', $dateKey)
                    ->get()
                    ->map(function ($task) {
                        return [
                            'type' => 'task',
                            'id' => $task->id,
                            'title' => $task->title,
                            'priority' => $task->priority,
                            'url' => route('tasks.show', $task)
                        ];
                    });
    
                // Step 3: Count milestones for the user's task projects
                $milestones = Milestone::whereIn('project_id', $projectIds)
                    ->whereDate('due_date', $dateKey)
                    ->get()
                    ->map(function ($milestone) {
                        return [
                            'type' => 'milestone',
                            'id' => $milestone->id,
                            'title' => $milestone->title,
                            'url' => route('projects.show', $milestone->project_id)
                        ];
                    });
    
                // Step 4: Combine tasks and milestones
                $week[$dateKey] = [
                    'date' => $currentDate->copy(),
                    'isToday' => $currentDate->isToday(),
                    'isCurrentMonth' => $currentDate->month === $date->month,
                    'items' => $tasks->concat($milestones)->toArray()
                ];
    
                $currentDate->addDay();
            }
            $weeks[] = $week;
        }
    
        return [
            'weeks' => $weeks,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
    

    private function getYearView(Carbon $date): array
    {
        $months = [];
        $startDate = $date->copy()->startOfYear();
    
        // Step 1: Get the project_ids for tasks assigned to the current user
        $projectIds = Task::where('assigned_to', Auth::id())
            ->pluck('project_id')
            ->unique();
    
        for ($month = 0; $month < 12; $month++) {
            $currentDate = $startDate->copy()->addMonths($month);
            $monthKey = $currentDate->format('Y-m');
    
            // Step 2: Count user's tasks per month
            $taskCount = Task::where('assigned_to', Auth::id())
                ->whereYear('due_date', $currentDate->year)
                ->whereMonth('due_date', $currentDate->month)
                ->count();
    
            // Step 3: Count milestones for the user's task projects
            $milestoneCount = Milestone::whereIn('project_id', $projectIds)
                ->whereYear('due_date', $currentDate->year)
                ->whereMonth('due_date', $currentDate->month)
                ->count();
    
            $months[$monthKey] = [
                'date' => $currentDate->copy(),
                'isCurrentMonth' => $currentDate->isCurrentMonth(),
                'taskCount' => $taskCount,
                'milestoneCount' => $milestoneCount
            ];
        }
    
        return [
            'months' => $months,
            'year' => $date->year
        ];
    }
    
}