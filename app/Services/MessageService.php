<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Database\Eloquent\Collection;

class MessageService
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    public function getByProject(int $projectId): Collection
    {
        return $this->messageRepository->getByProject($projectId);
    }

    public function getByTask(int $taskId): Collection
    {
        return $this->messageRepository->getByTask($taskId);
    }

    public function createMessage(array $data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function updateMessage(Message $message, array $data): Message
    {
        return $this->messageRepository->update($message, $data);
    }

    public function deleteMessage(Message $message): bool
    {
        return $this->messageRepository->delete($message);
    }
}