<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function all(): Collection
    {
        return Task::with(['project', 'assignedUser'])->latest()->get();
    }

    public function findById(int $id): ?Task
    {
        return Task::with(['project', 'assignedUser', 'subtasks'])->where('id', $id)->first();
    }

    public function getByProject(int $projectId): Collection
    {
        return Task::where('project_id', $projectId)
            ->with(['assignedUser', 'subtasks'])
            ->latest()
            ->get();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}