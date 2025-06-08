<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository
{
    public function getByProject(int $projectId): Collection
    {
        return Message::where('project_id', $projectId)
            ->with(['user'])
            ->latest()
            ->get();
    }

    public function getByTask(int $taskId): Collection
    {
        return Message::where('task_id', $taskId)
            ->with(['user'])
            ->latest()
            ->get();
    }

    public function create(array $data): Message
    {
        return Message::create($data);
    }

    public function update(Message $message, array $data): Message
    {
        $message->update($data);
        return $message;
    }

    public function delete(Message $message): bool
    {
        return $message->delete();
    }
}