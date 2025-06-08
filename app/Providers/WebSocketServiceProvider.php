<?php

namespace App\Providers;

use App\Events\TaskAssigned;
use App\Events\ProjectStatusUpdated;
use App\Events\NewMessage;
use App\Models\Task;
use App\Models\Project;
use App\Models\Message;
use Illuminate\Support\ServiceProvider;

class WebSocketServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Task::created(function ($task) {
            broadcast(new TaskAssigned($task));
        });

        Project::updated(function ($project) {
            if ($project->isDirty('status')) {
                broadcast(new ProjectStatusUpdated($project));
            }
        });

        Message::created(function ($message) {
            broadcast(new NewMessage($message));
        });
    }
}