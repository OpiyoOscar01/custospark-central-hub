<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Models\Resource;
use App\Services\ResourceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResourceController extends Controller
{
    // public function __construct(private ResourceService $resourceService)
    // {
    //     $this->authorizeResource(Resource::class, 'resource');
    // }

    // public function index(Project $project): View
    // {
    //     $resources = $this->resourceService->getByProject($project->id);
    //     return view('resources.index', compact('resources', 'project'));
    // }

    // public function create(Project $project): View
    // {
    //     return view('resources.create', compact('project'));
    // }

    // public function store(ResourceRequest $request): RedirectResponse
    // {
    //     $this->resourceService->createResource($request->validated());
    //     return redirect()->route('projects.show', $request->project_id)->with('success', 'Resource created successfully.');
    // }

    // public function edit(Resource $resource): View
    // {
    //     return view('resources.edit', compact('resource'));
    // }

    // public function update(ResourceRequest $request, Resource $resource): RedirectResponse
    // {
    //     $this->resourceService->updateResource($resource, $request->validated());
    //     return redirect()->route('projects.show', $resource->project_id)->with('success', 'Resource updated successfully.');
    // }

    // public function destroy(Resource $resource): RedirectResponse
    // {
    //     $projectId = $resource->project_id;
    //     $this->resourceService->deleteResource($resource);
    //     return redirect()->route('projects.show', $projectId)->with('success', 'Resource deleted successfully.');
    // }
    protected $resourceService;

    public function __construct(ResourceService $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    // List resources
    public function index()
    {
        $resources = $this->resourceService->getAllResources();
       
            // Fetch the count for each resource type
            $stats = [
                'total' => Resource::count(),
                'documents' => Resource::where('resource_type', 'document')->count(),
                'videos' => Resource::where('resource_type', 'video')->count(),
                'links' => Resource::where('resource_type', 'link')->count(),
                'templates' => Resource::where('resource_type', 'template')->count(),
                'guides' => Resource::where('resource_type', 'guide')->count(),
            ];
    
            // Return the view with the stats data
            return view('resources.index', compact('stats','resources'));
    }

    // Create a new resource
    public function store(ResourceRequest $request)
    {
        $resource = $this->resourceService->createResource($request->validated());
        return response()->json($resource, 201);
    }

    // Show a specific resource
    public function show($id)
    {
        $resource = $this->resourceService->getResourceById($id);
        return response()->json($resource);
    }

    // Update an existing resource
    public function update(ResourceRequest $request, $id)
    {
        $resource = $this->resourceService->updateResource($id, $request->validated());
        return response()->json($resource);
    }

    // Delete a resource
    public function destroy($id)
    {
        $this->resourceService->deleteResource($id);
        return response()->json(null, 204);
    }
}