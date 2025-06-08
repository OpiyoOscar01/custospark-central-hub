<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubtaskRequest;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\SubtaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class SubtaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private SubtaskService $subtaskService)
    {
      
    }

    protected function booted(): void
    {
        $this->authorizeResource(Subtask::class, 'subtask');
    }

    public function index(Task $task): View
    {
        $subtasks = $this->subtaskService->getByTask($task->id);
        return view('subtasks.index', compact('subtasks', 'task'));
    }

    public function create(Task $task): View
    {
        $users = $this->subtaskService->getUsers();
        return view('subtasks.create', compact('task', 'users'));
    }

    public function store(SubtaskRequest $request): RedirectResponse
    {
        $this->subtaskService->createSubtask($request->validated());
        return redirect()->route('tasks.show', $request->task_id)->with('success', 'Subtask created successfully.');
    }

    public function edit(Subtask $subtask): View
    {
        $users = $this->subtaskService->getUsers();
        return view('subtasks.edit', compact('subtask', 'users'));
    }

    public function update(SubtaskRequest $request, Subtask $subtask): RedirectResponse
    {
        $this->subtaskService->updateSubtask($subtask, $request->validated());
        return redirect()->route('tasks.show', $subtask->task_id)->with('success', 'Subtask updated successfully.');
    }

    public function destroy(Subtask $subtask): RedirectResponse
    {
        $taskId = $subtask->task_id;
        $this->subtaskService->deleteSubtask($subtask);
        return redirect()->route('tasks.show', $taskId)->with('success', 'Subtask deleted successfully.');
    }
}