<?php

namespace App\Services;

use App\Models\Subtask;
use App\Models\User;
use App\Repositories\SubtaskRepository;
use Illuminate\Database\Eloquent\Collection;

class SubtaskService
{
    public function __construct(private SubtaskRepository $subtaskRepository)
    {
    }

    public function getByTask(int $taskId): Collection
    {
        return $this->subtaskRepository->getByTask($taskId);
    }

    public function getUsers(): Collection
    {
        return User::all();
    }

    public function createSubtask(array $data): Subtask
    {
        return $this->subtaskRepository->create($data);
    }

    public function updateSubtask(Subtask $subtask, array $data): Subtask
    {
        return $this->subtaskRepository->update($subtask, $data);
    }

    public function deleteSubtask(Subtask $subtask): bool
    {
        return $this->subtaskRepository->delete($subtask);
    }
}