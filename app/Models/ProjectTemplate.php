<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'structure',
        'resource_allocation',
        'created_by'
    ];

    protected $casts = [
        'structure' => 'array',
        'resource_allocation' => 'array'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createProject(array $data): Project
    {
        $project = Project::create(array_merge($data, [
            'name' => $data['name'] ?? $this->name,
            'description' => $data['description'] ?? $this->description,
        ]));

        // Create tasks from template
        if (!empty($this->structure['tasks'])) {
            foreach ($this->structure['tasks'] as $taskData) {
                $task = $project->tasks()->create([
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'priority' => $taskData['priority'],
                    'status' => 'pending',
                    'due_date' => now()->addDays($taskData['duration_days']),
                ]);

                // Create subtasks if any
                if (!empty($taskData['subtasks'])) {
                    foreach ($taskData['subtasks'] as $subtaskData) {
                        $task->subtasks()->create($subtaskData);
                    }
                }
            }
        }

        // Create milestones from template
        if (!empty($this->structure['milestones'])) {
            foreach ($this->structure['milestones'] as $milestoneData) {
                $project->milestones()->create($milestoneData);
            }
        }

        // Assign team members based on resource allocation
        if (!empty($this->resource_allocation)) {
            foreach ($this->resource_allocation as $role => $count) {
                // Logic to assign available team members based on role and count
            }
        }

        return $project;
    }
}