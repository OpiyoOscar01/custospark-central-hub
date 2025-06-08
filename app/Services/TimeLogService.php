<?php

namespace App\Services;

use App\Models\TimeLog;
use App\Repositories\TimeLogRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\TimeLogExport; // Import the TimeLogExport class
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade
use Carbon\Carbon;
use Mpdf\Mpdf;


class TimeLogService
{
    public function __construct(private TimeLogRepository $timeLogRepository)
    {
    }

    public function getFilteredLogs(Request $request): Collection
    {
        $query = TimeLog::query()
            ->with(['task', 'task.project', 'user']);

        // Filter by task
        if ($request->has('task_id')) {
            $query->where('task_id', $request->task_id);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->where('date_logged', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('date_logged', '<=', $request->end_date);
        }

        // Filter by billable status
        if ($request->has('is_billable')) {
            $query->where('is_billable', $request->is_billable);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Sort by date logged
        $query->orderBy('date_logged', 'desc');

        return $query->get();
    }

    public function getByTask(int $taskId): Collection
    {
        return $this->timeLogRepository->getByTask($taskId);
    }

    public function getByUser(int $userId): Collection
    {
        return $this->timeLogRepository->getByUser($userId);
    }

    public function createTimeLog(array $data): TimeLog
    {
        return $this->timeLogRepository->create($data);
    }

    public function updateTimeLog(TimeLog $timeLog, array $data): TimeLog
    {
        return $this->timeLogRepository->update($timeLog, $data);
    }

    public function deleteTimeLog(TimeLog $timeLog): bool
    {
        return $this->timeLogRepository->delete($timeLog);
    }

    public function startTimer(int $taskId): void
    {
        $timeLog = new TimeLog([
            'task_id' => $taskId,
            'user_id' => Auth::id(),
            'start_time' => now(),
            'date_logged' => now()->toDateString(),
            'status' => 'pending',
            'is_billable' => true,
            'description' => 'Timer started',
            'hours_worked' => 0,
            'actual_hours_worked' => 0,
            'rate' => 0,
        ]);
    
        $timeLog->save();
    }
    
    public function stopTimer(int $taskId): void
    {
        $timeLog = TimeLog::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->latest()
            ->first();
    
        if (!$timeLog) {
            return; // Exit early if no active timer is found
        }
    
        $timeLog->end_time = now();
    
        // Calculate hours worked
        $startTime = Carbon::parse($timeLog->start_time);
        $endTime = Carbon::parse($timeLog->end_time);
        $hoursWorked = $startTime->diffInHours($endTime);
    
        // Ensure the calculation is reflected properly
        $timeLog->hours_worked = $hoursWorked;
        $timeLog->actual_hours_worked = $hoursWorked;
        $timeLog->description = 'Timer stopped';
        $timeLog->status = 'pending'; // Set status to pending or any other status as needed.
        $timeLog->save();
    }

    public function approveTimeLog(TimeLog $timeLog): void
    {
        $timeLog->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);
    }

    public function rejectTimeLog(TimeLog $timeLog, string $reason): void
    {
        $timeLog->update([
            'status' => 'rejected',
            'rejection_reason' => $reason
        ]);
    }
    public function exportTimeLogs(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Get filtered time logs
        $timeLogs = $this->getFilteredLogs($request);
    
        // Filter out time logs with missing project or task
        $timeLogs = $timeLogs->filter(function ($timeLog) {
            return $timeLog->task && $timeLog->task->project;
        });
    
        // Format data for export
        $exportData = $timeLogs->map(function ($timeLog) {
            return [
                'Date' => $timeLog->date_logged->format('Y-m-d'),
                'Project' => $timeLog->task->project->name,
                'Task' => $timeLog->task->title,
                'User' => $timeLog->user->name,
                'Hours' => number_format($timeLog->hours_worked, 2),
                'Description' => $timeLog->description,
                'Status' => ucfirst($timeLog->status),
                'Billable' => $timeLog->is_billable ? 'Yes' : 'No',
                'Rate' => number_format($timeLog->rate, 2),
                'Total Amount' => number_format($timeLog->hours_worked * $timeLog->rate, 2),
            ];
        })->toArray();
    
        // Create export class instance
        $export = new TimeLogExport($exportData);
    
        // Generate filename
        $filename = 'time_logs_' . now()->format('Y_m_d_His');
    
        // Export based on requested format
        return match($request->format) {
            'pdf' => Excel::download($export, $filename . '.pdf', \Maatwebsite\Excel\Excel::MPDF),
            'csv' => Excel::download($export, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV),
            default => Excel::download($export, $filename . '.xlsx')
        };
    }
    
}