<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeLogRequest;
use App\Models\TimeLog;
use App\Services\TimeLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TimeLogController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private TimeLogService $timeLogService)
    {
      $this->timeLogService = $timeLogService;
    }
    protected function booted(): void
    {

        $this->authorizeResource(TimeLog::class, 'timeLog');    }

    public function index(Request $request): View
    {
        $timeLogs = $this->timeLogService->getFilteredLogs($request);
        return view('time-logs.index', compact('timeLogs'));
    }

    public function create(): View
    {
        return view('time-logs.create');
    }

    public function store(TimeLogRequest $request): RedirectResponse
    {
        $this->timeLogService->createTimeLog($request->validated());
        return redirect()->route('time-logs.index')->with('success', 'Time log created successfully.');
    }

    public function edit(TimeLog $timeLog): View
    {
        return view('time-logs.edit', compact('timeLog'));
    }

    public function update(TimeLogRequest $request, TimeLog $timeLog): RedirectResponse
    {
        $this->timeLogService->updateTimeLog($timeLog, $request->validated());
        return redirect()->route('time-logs.index')->with('success', 'Time log updated successfully.');
    }

    public function destroy(TimeLog $timeLog): RedirectResponse
    {
        $this->timeLogService->deleteTimeLog($timeLog);
        return redirect()->route('time-logs.index')->with('success', 'Time log deleted successfully.');
    }

    public function startTimer(Request $request): RedirectResponse
    {
        // dd($request->task_id);
        $this->timeLogService->startTimer($request->task_id);
        return back()->with('success', 'Timer started successfully.');
    }

    public function stopTimer(Request $request): RedirectResponse
    {
        $this->timeLogService->stopTimer($request->task_id);
        return back()->with('success', 'Timer stopped successfully.');
    }

    public function approve(TimeLog $timeLog): RedirectResponse
    {
        $this->timeLogService->approveTimeLog($timeLog);
        return back()->with('success', 'Time log approved successfully.');
    }


public function reject(TimeLog $timeLog, Request $request): RedirectResponse
{
    // Get the rejection reason or set a default message
    $reason = $request->has('reason') ? $request->input('reason') : 'No reason provided';

    // Call the service method with timeLog and rejection reason
    $this->timeLogService->rejectTimeLog($timeLog, $reason);

    return back()->with('success', 'Time log rejected.');
}


    public function export(Request $request)
    {
        return $this->timeLogService->exportTimeLogs($request);
    }
}