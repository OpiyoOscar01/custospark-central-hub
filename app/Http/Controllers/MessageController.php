<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class MessageController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private MessageService $messageService)
    {
        $this->messageService = $messageService;
    }
    protected function booted(): void
    {

        $this->authorizeResource(Message::class, 'message');  
     }

     public function index(?Project $project, ?Task $task): View
     {
         // Use null coalescing to ensure safe access
         $messages = $project 
             ? $this->messageService->getByProject($project->id)
             : ($task ? $this->messageService->getByTask($task->id) : collect()); // Ensure no errors if both are null
     
         return view('messages.index', compact('messages', 'project', 'task'));
     }

    public function store(MessageRequest $request): RedirectResponse
    {
        $this->messageService->createMessage($request->validated());
        
        if ($request->project_id) {
            return redirect()->route('projects.show', $request->project_id)
                ->with('success', 'Message sent successfully.');
        }
        
        return redirect()->route('tasks.show', $request->task_id)
            ->with('success', 'Message sent successfully.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $projectId = $message->project_id;
        $taskId = $message->task_id;
        
        $this->messageService->deleteMessage($message);
        
        if ($projectId) {
            return redirect()->route('projects.show', $projectId)
                ->with('success', 'Message deleted successfully.');
        }
        
        return redirect()->route('tasks.show', $taskId)
            ->with('success', 'Message deleted successfully.');
    }
}