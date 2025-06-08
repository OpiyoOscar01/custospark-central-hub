<?php

namespace App\Repositories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepository
{
    // public function getByProject(int $projectId): Collection
    // {
    //     return Resource::where('project_id', $projectId)
    //         ->latest()
    //         ->get();
    // }

    // public function create(array $data): Resource
    // {
    //     return Resource::create($data);
    // }

    // public function update(Resource $resource, array $data): Resource
    // {
    //     $resource->update($data);
    //     return $resource;
    // }

    // public function delete(Resource $resource): bool
    // {
    //     return $resource->delete();
    // }
                protected $model;

                public function __construct(Resource $resource)
                {
                    $this->model = $resource;
                }

                // Get all resources
                public function getAll()
                {
                    return $this->model::all();
                }

                // Create a new resource
                public function create(array $data)
                {
                    return $this->model::create($data);
                }

                // Find a resource by ID
                public function find($id)
                {
                    return $this->model::findOrFail($id);
                }

                // Update an existing resource
                public function update($id, array $data)
                {
                    $resource = $this->model::findOrFail($id);
                    $resource->update($data);
                    return $resource;
                }

                // Delete a resource
                public function delete($id)
                {
                    $resource = $this->model::findOrFail($id);
                    $resource->delete();
                }
}