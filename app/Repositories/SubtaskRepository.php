<?php

namespace App\Repositories;

use App\Models\Subtask;
use Illuminate\Database\Eloquent\Collection;

class SubtaskRepository
{
    public function getByTask(int $taskId): Collection
    {
        return Subtask::where('task_id', $taskId)
            ->with('assignedUser')
            ->latest()
            ->get();
    }

    public function create(array $data): Subtask
    {
        return Subtask::create($data);
    }

    public function update(Subtask $subtask, array $data): Subtask
    {
        $subtask->update($data);
        return $subtask;
    }

    public function delete(Subtask $subtask): bool
    {
        return $subtask->delete();
    }
}