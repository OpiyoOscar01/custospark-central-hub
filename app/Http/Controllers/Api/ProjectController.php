<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Project::query();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $projects = $query->paginate($request->per_page ?? 15);

        return ProjectResource::collection($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,on_hold',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
        ]);

        $project = Project::create($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $project->addMedia($document)
                    ->toMediaCollection('documents');
            }
        }

        return response()->json([
            'message' => 'Project created successfully',
            'data' => new ProjectResource($project),
        ], 201);
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project->load(['client', 'teamMembers.user', 'tasks']));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed,on_hold',
            'priority' => 'sometimes|required|in:low,medium,high,urgent',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'budget' => 'sometimes|required|numeric|min:0',
            'client_id' => 'sometimes|required|exists:clients,id',
        ]);

        $project->update($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $project->addMedia($document)
                    ->toMediaCollection('documents');
            }
        }

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $results = Project::search($request->search)
            ->query(function ($query) use ($request) {
                if ($request->has('status')) {
                    $query->where('status', $request->status);
                }
                if ($request->has('priority')) {
                    $query->where('priority', $request->priority);
                }
            })
            ->paginate($request->per_page ?? 15);

        return ProjectResource::collection($results);
    }

    public function documents(Project $project): JsonResponse
    {
        $documents = $project->getMedia('documents')->map(function ($media) {
            return [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'url' => $media->getUrl(),
                'created_at' => $media->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $documents,
        ]);
    }
}