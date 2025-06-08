<?php

namespace App\Repositories;

use App\Models\TimeLog;
use Illuminate\Database\Eloquent\Collection;

class TimeLogRepository
{
    public function getByTask(int $taskId): Collection
    {
        return TimeLog::where('task_id', $taskId)
            ->with(['user'])
            ->latest()
            ->get();
    }

    public function getByUser(int $userId): Collection
    {
        return TimeLog::where('user_id', $userId)
            ->with(['task', 'task.project'])
            ->latest()
            ->get();
    }

    public function create(array $data): TimeLog
    {
        return TimeLog::create($data);
    }

    public function update(TimeLog $timeLog, array $data): TimeLog
    {
        $timeLog->update($data);
        return $timeLog;
    }

    public function delete(TimeLog $timeLog): bool
    {
        return $timeLog->delete();
    }
}