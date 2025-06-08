<?php

namespace App\Services;

use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Database\Eloquent\Collection;

class ResourceService
{
    // public function __construct(private ResourceRepository $resourceRepository)
    // {
    // }

    // public function getByProject(int $projectId): Collection
    // {
    //     return $this->resourceRepository->getByProject($projectId);
    // }

    // public function createResource(array $data): Resource
    // {
    //     return $this->resourceRepository->create($data);
    // }

    // public function updateResource(Resource $resource, array $data): Resource
    // {
    //     return $this->resourceRepository->update($resource, $data);
    // }

    // public function deleteResource(Resource $resource): bool
    // {
    //     return $this->resourceRepository->delete($resource);
 
    // }
            protected $resourceRepo;

            public function __construct(ResourceRepository $resourceRepo)
            {
                $this->resourceRepo = $resourceRepo;
            }

            // Get all resources
            public function getAllResources()
            {
                return $this->resourceRepo->getAll();
            }

            // Create a new resource
            public function createResource(array $data)
            {
                return $this->resourceRepo->create($data);
            }

            // Get a single resource by ID
            public function getResourceById($id)
            {
                return $this->resourceRepo->find($id);
            }

            // Update an existing resource
            public function updateResource($id, array $data)
            {
                return $this->resourceRepo->update($id, $data);
            }

            // Delete a resource
            public function deleteResource($id)
            {
                $this->resourceRepo->delete($id);
            }
}